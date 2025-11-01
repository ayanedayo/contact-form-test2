{{-- resources/views/products/register.blade.php --}}
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container register">
  <h2 class="page-title">商品登録</h2>

  <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
      <label for="name">商品名 <span class="req">必須</span></label>
      <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="商品名を入力">
      @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="price">値段 <span class="req">必須</span></label>
      <input id="price" type="number" name="price" value="{{ old('price') }}" placeholder="例: 800">
      @error('price') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="form-group">
      <label for="image">商品画像 <span class="req">必須</span></label>
      <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)">
      <div id="image-preview" class="image-preview" style="margin-top: 10px;">
      <img id="preview" src="" alt="プレビュー" style="max-width: 200px; display: none;">
    </div>
      @error('image') <p class="error">{{ $message }}</p> @enderror
    </div>



    <div class="form-group">
    <label class="label">季節 <span class="req">※必須</span></label>

    @php $oldSeasons = collect(old('seasons', [])); @endphp

    <div class="radios">
    @foreach($seasons as $season)
      <label style="margin-right:1rem;">
        <input type="checkbox"
               name="seasons[]"
               value="{{ $season->id }}"
               {{ $oldSeasons->contains($season->id) ? 'checked' : '' }}>
        {{ $season->name }}
      </label>
      @endforeach
    </div>

  @error('seasons')    <p class="error">{{ $message }}</p> @enderror
</div>

    <div class="form-group">
      <label for="description">商品説明 <span class="req">必須</span></label>
      <textarea id="description" name="description" rows="5" placeholder="120文字以内で入力">{{ old('description') }}</textarea>
      @error('description') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div class="actions">
      <a href="{{ route('products.index') }}" class="btn btn-secondary">戻る</a>
      <button type="submit" class="btn btn-primary">登録</button>
    </div>
  </form>
</div>
<script>
function previewImage(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('preview');
  
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.style.display = 'block';
    };
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
    preview.style.display = 'none';
  }
}
</script>
@endsection