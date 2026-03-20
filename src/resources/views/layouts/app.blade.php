<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>coachtechフリマ</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  @yield('css')
</head>
<body>
  <header class="header">
    <div class="header__inner">
      <div class="header__left">
         <a href="/">
        <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH" class="header__logo-image" />
         </a>
      </div>

      <div class="header-center">
            <form action="{{ route('item.index') }}" method="GET" class="search-form">
                <input type="hidden" name="tab" value="{{ $tab?? '' }}">
                <input type="text" name="keyword" placeholder="なにをお探しですか？" class="search-input">
            </form>
        </div>

        <nav class="header-right">
            @auth
            <!-- ログインしている時 -->
            <form action="{{ route('logout') }}" method="POST">
              @csrf
              <button type="submit" class="nav-item">ログアウト</button>
            </form>
            <a href="{{ route('profile.index') }}" class="nav-item">マイページ</a>
            @endauth

            @guest
            <!-- ログインしていない時 -->
             <a href="{{ route('login') }}" class="nav-item">ログイン</a>
             <a href="{{ route('register') }}" class="nav-item">会員登録</a>
            @endguest

            <a href="{{ route('item.create') }}" class="sell-button">出品</a>
        </nav>
    </div>
  </header>

  <main>
    @yield('content')
  </main>
</body>
</html>