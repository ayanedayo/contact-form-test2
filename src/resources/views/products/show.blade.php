@extends('layouts.app')

@push('page-css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endpush

@section('content')
<div class="detail-page">

  <div class="detail-head">
    <h2 class="detail-title">商品詳細・変更</h2>
  </div>

  <div class="detail-grid">
    <div class="detail-image">
    <img id="preview" src="{{ $product->image_url }}" alt="{{ $product->name }}" >
      <label class="file-label">
        <input type="file" name="image" form="updateForm" accept="image/png,image/jpeg"
               onchange="previewImage(event)">
        ファイルを選択_
      </label>
      @error('image')
        <p class="error">{{ $message }}</p>
      @enderror
      <p class="filename" id="filename"></p>
    </div>

    <form id="updateForm" class="detail-form"
          action="{{ url("/products/{$product->id}/update") }}"
          method="POST" enctype="multipart/form-data">
      @csrf

      <label class="field">
        <span class="label">商品名 <span class="req">必須</span></span>
        <input type="text" name="name" value="{{ old('name', $product->name) }}">
        @error('name')<p class="error">{{ $message }}</p>@enderror
      </label>

      <label class="field">
        <span class="label">価格 <span class="req">必須</span></span>
        <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" max="10000">
        @error('price')<p class="error">{{ $message }}</p>@enderror
      </label>

      @php
        $season = old('season', $product->season);
        $opts = ['春','夏','秋','冬'];
      @endphp


      <div class="form-group">
       <label class="label">季節 <span class="req">※必須</span></label>

       @php
       $selected = old('seasons', $product->seasons->pluck('id')->all());
       @endphp

       <div class="radios">
       @foreach($seasons ?? '' as $season)
       <label style="margin-right:1rem;">
        <input type="checkbox"
               name="seasons[]"
               value="{{ $season->id }}"
               {{ in_array($season->id, $selected) ? 'checked' : '' }}>
        {{ $season->name }}
        </label>
        @endforeach
        </div>

  @error('seasons')    <p class="error">{{ $message }}</p> @enderror
</div>

      <label class="field">
        <span class="label">商品説明 <span class="req">必須</span></span>
        <textarea name="description" rows="6" maxlength="120"
          placeholder="120文字以内で入力してください">{{ old('description', $product->description) }}</textarea>
        @error('description')<p class="error">{{ $message }}</p>@enderror
      </label>

      <form id="updateForm" class="detail-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="form-actions">
        <a href="{{ url('/products') }}" class="btn-secondary">戻る</a>
        <button type="submit" class="btn-primary">変更を保存</button>
       </div>
      </form>

        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-delete" aria-label="削除">🗑</button>
        </form>
      </div>
    </form>
  </div>
</div>
@endsection

@push('page-js')
<script>
function previewImage(event){
  const file = event.target.files && event.target.files[0];
  const preview = document.getElementById('preview');
  const nameEl  = document.getElementById('filename');
  if (!file){ preview.src = "{{ asset('images/noimage.png') }}"; nameEl.textContent=''; return; }
  nameEl.textContent = file.name;
  const reader = new FileReader();
  reader.onload = e => { preview.src = e.target.result; };
  reader.readAsDataURL(file);
}
</script>
@endpush