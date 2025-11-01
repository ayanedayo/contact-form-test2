<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Season;

class ProductController extends Controller {

public function index(Request $request)
{
    $kw  = trim((string) $request->input('keyword', ''));
    $dir = $request->input('dir', '');

    $q = Product::query()->keyword($kw);

    if (in_array($dir, ['asc', 'desc'], true)) {
        $q->orderBy('price', $dir);
        $q->orderBy('id', 'asc');

    $products = Product::with('seasons')->paginate(12);
        return view('products.index', compact('products'));
    }

    $products = $q->paginate(6)->withQueryString();

    return view('products.index', compact('products', 'kw', 'dir'));
}
public function show(Product $product) {
    $seasons = Season::all();

    return view('products.show', compact('product','seasons'));
}


public function create() {
    $seasons = Season::all();
    return view('products.register', compact('seasons'));

}

public function store(Request $request) {
    $validated = $request->validate([
            'name'        => ['required','string','max:255'],
            'price'       => ['required','integer','between:0,100000'],
            'description' => ['required','string','max:120'],
            'image'       => ['required','image','mimes:jpg,jpeg,png'],
            'season_ids'   => ['required','array','min:1'],
            'season_ids.*' => ['integer','exists:seasons,id'],
        ]);
        ([
            'name.required'        => '商品名を入力してください',
            'price.required'       => '値段を入力してください',
            'price.integer'        => '数値で入力してください',
            'price.between'        => '0〜10000円以内で入力してください',
            'season.required'      => '季節を選択してください',
            'season.in'            => '季節を選択してください',
            'description.required' => '商品説明を入力してください',
            'description.max'      => '120文字以内で入力してください',
            'image.required'       => '商品画像を登録してください',
            'image.image'          => '画像ファイルを選択してください',
            'image.mimes'          => 'jpg または png 形式でアップロードしてください',
    ]);
    $path = null;
        if ($request->hasFile('image')) {
            $filename = Str::uuid()->toString().'.'.$request->file('image')->extension();
            $stored = $request->file('image')->store('public/images', $filename);
            $path = Storage::url($stored);
        }

        $Product = Product::create([
            'name'        => $validated['name'],
            'price'       => $validated['price'],
            'description' => $validated['description'], 
            'image_path'  =>$path,
        ]);
        $product->seasons()->sync($validated['season_ids']);
        return redirect()->route('products.index')->with('success','登録しました');

    }
    public function update(Request $request, Product $product) {
        $validated = $request->validate([
            'name'        => ['required','string','max:255'],
            'price'       => ['required','integer','between:0,100000'],
            'description' => ['required','string','max:120'],
            'image'       => ['nullable','image','mimes:jpg,jpeg,png'],
            'season_ids'   => ['required','array','min:1'],
            'season_ids.*' => ['integer','exists:seasons,id'],
        ]);
        if ($request->hasFile('image')) {
            $stored = $request->file('image')->store('public/images');
            $validated['image_path'] = Storage::url($stored);
        }

        $product->update($validated);
        $product->seasons()->sync($validated['season_ids']);
        return redirect()->route('products.index')->with('success','更新しました');
    }


public function destroy(Product $product) {

    if ($product->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $product->image_path))) {
        Storage::disk('public')->delete(str_replace('storage/', '', $product->image_path));
    }
    $product->delete();
    return redirect('/products')->with('success','削除しました');
}
public function scopeKeyword($query, $kw)
{
    if ($kw !== '') {
        $query->where('name', 'like', "%{$kw}%");
    }
    return $query;
}
public function seasons()
{
    return $this->belongsToMany(Season::class, 'product_season');
}

}