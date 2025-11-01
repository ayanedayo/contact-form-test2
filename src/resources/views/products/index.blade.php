@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
  <div class="page-head">
    <h2 class="page-title">商品一覧</h2>
    <a href="{{ url('/products/register') }}" class="btn-add">＋ 商品を追加</a>
  </div>

  <div class="page">
    <aside class="sidebar">
      <form method="GET" action="{{ url('/products') }}" class="search-form">
        <label class="field">
          <input type="text" name="keyword" value="{{ $kw ?? '' }}"
                 placeholder="商品名で検索" aria-label="商品名で検索">
        </label>
        <button type="submit" class="btn-search">検索</button>

        <p class="caption">価格順で表示</p>
        <input type="hidden" name="sort" value="price">
        <select name="dir" class="select" onchange="this.form.submit()">
          <option value="asc"  {{ ($dir ?? 'asc')==='asc'  ? 'selected' : '' }}>安い順</option>
          <option value="desc" {{ ($dir ?? '')==='desc' ? 'selected' : '' }}>高い順</option>
        </select>
      </form>
    </aside>

    <section class="cards">
      @foreach($products as $product)
        <a href="/products/{{ $product->id }}" class="card">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
          <p class="name">{{ $product->name }}</p>
          <p class="price">¥{{ number_format($product->price) }}</p>
        </a>
      @endforeach

      <div class="pagination">
        {{ $products->appends(request()->query())->links() }}
      </div>
    </section>
  </div>
@endsection