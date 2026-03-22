<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>メール認証 - coachtechフリマ</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
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
        <div class="verify-email-container">
            <div class="verify-email-card">
                <p class="verify-email-text">
                    登録していただいたメールアドレスに認証メールを送付しました。<br>
                    メール認証を完了してください。
                </p>

                <div class="verify-email-action">
                    <a href="http://localhost:8025" target="_blank" class="verify-email-button">認証はこちらから</a>
                </div>

                <form method="POST" action="{{ route('verification.send') }}" class="verify-email-resend-form">
                    @csrf
                    <button type="submit" class="verify-email-resend-link">
                        認証メールを再送する
                    </button>
                </form>

                @if (session('status') == 'verification-link-sent')
                    <p class="verify-email-success" style="color: green; margin-top: 20px;">
                        新しい認証メールを再送しました。
                    </p>
                @endif
            </div>
        </div>
    </main>
</body>

</html>
