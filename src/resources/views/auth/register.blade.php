<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>メール認証 - coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>

<body>
    <header class="header">
        <div class="header-inner">
            <div class="header-left">
                <a href="/">
                    <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH" class="header-logo-image" />
                </a>
            </div>
        </div>
    </header>

    <main>
        <div class="register-form-content">
            <div class="register-form-heading">
                <h1>会員登録</h1>
            </div>

            <form class="form" method="POST" action="{{ route('register') }}" novalidate>
                @csrf

                <div class="form-group">
                    <div class="form-group-title">
                        <span class="form-label-item">ユーザー名</span>
                    </div>
                    <div class="form-group-content">
                        <div class="form-input-text">
                            <input type="text" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="form-error">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group-title">
                        <span class="form-label-item">メールアドレス</span>
                    </div>
                    <div class="form-group-content">
                        <div class="form-input-text">
                            <input type="email" name="email" value="{{ old('email') }}" />
                        </div>
                        <div class="form-error">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group-title">
                        <span class="form-label-item">パスワード</span>
                    </div>
                    <div class="form-group-content">
                        <div class="form-input-text">
                            <input type="password" name="password" />
                        </div>
                        <div class="form-error">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-group-title">
                        <span class="form-label-item">確認用パスワード</span>
                    </div>
                    <div class="form-group-content">
                        <div class="form-input-text">
                            <input type="password" name="password_confirmation" />
                        </div>
                        <div class="form-error">
                            @error('password_confirmation')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-button">
                    <button class="form-button-submit" type="submit">登録する</button>
                </div>
            </form>

            <div class="login-link">
                <a class="login-button-submit" href="{{ route('login') }}">ログインはこちら</a>
            </div>
        </div>
    </main>
</body>

</html>
