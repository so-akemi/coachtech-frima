@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="verify-email__container">
    <div class="verify-email__card">
        <p class="verify-email__text">
            登録していただいたメールアドレスに認証メールを送付しました。<br>
            メール認証を完了してください。
        </p>

        <!-- 認証メールから遷移してきたと仮定したボタン（要件画像 image_79f4a3.png に基づく） -->
        <div class="verify-email__action">
            <a href="http://localhost:8025" target="_blank" class="verify-email__button">認証はこちらから</a>
        </div>

        <!-- 再送用フォーム -->
        <form method="POST" action="{{ route('verification.send') }}" class="verify-email__resend-form">
            @csrf
            <button type="submit" class="verify-email__resend-link">
                認証メールを再送する
            </button>
        </form>

        @if (session('status') == 'verification-link-sent')
            <p class="verify-email__success">
                新しい認証メールを再送しました。
            </p>
        @endif
    </div>
</div>
@endsection