<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>@yield('title', 'Products')</title>


  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">

  @stack('page-css')
  @yield('css')
</head>
<body>

  <header class="site-header">
    <div class="container header-inner">
      <h1 class="logo">
        <a href="{{ route('products.index') }}" class="site-logo" aria-label="商品一覧へ戻る">
        mogitate
        </a>
      </h1>
    </div>
  </header>

  <main class="site-main">
    <div class="container">
      @yield('content')
    </div>
  </main>

  @stack('page-js')
</body>
</html>