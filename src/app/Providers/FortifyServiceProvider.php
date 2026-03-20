<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        $this->app->bind(
        \Laravel\Fortify\Http\Requests\LoginRequest::class,
        \App\Http\Requests\LoginRequest::class
        );

        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(10)->by($email . $request->ip());
        });

        // ログインバリデーションのカスタマイズ
        Fortify::authenticateThrough(function (Request $request) {
            $loginRequest = new LoginRequest();
            
            // Validatorにrules, messagesに加えて attributes() を渡すことで
            // 「emailは〜」という表示を「メールアドレスは〜」に上書きします。
            Validator::make(
                $request->all(), 
                $loginRequest->rules(), 
                $loginRequest->messages(),
                $loginRequest->attributes() // ここを追加
            )->validate();

            return array_filter([
                config('fortify.limiters.login') ? \Laravel\Fortify\Actions\EnsureLoginIsNotThrottled::class : null,
                \Laravel\Fortify\Actions\PrepareAuthenticatedSession::class,
                \Laravel\Fortify\Actions\AttemptToAuthenticate::class,
                \Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable::class,
            ]);
        });

        Fortify::verifyEmailView(function () {
        return view('auth.verify-email');
        });

        // 1. ログイン成功時のリダイレクト先を動的に変更する
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
          public function toResponse($request) {
            $user = auth()->user();
            // 住所（郵便番号）がなければプロフィール設定へ、あればトップへ
            $redirect = is_null($user->postal_code) ? route('profile.edit') : '/';
            return redirect()->intended($redirect);
          }
        });

        // 2. 会員登録成功時のリダイレクト先を固定する
        // RouteServiceProvider::HOME を無視して、確実に「認証誘導画面」へ飛ばす
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
          public function toResponse($request) {
            return redirect()->route('verification.notice');
          }
        });
    }
}