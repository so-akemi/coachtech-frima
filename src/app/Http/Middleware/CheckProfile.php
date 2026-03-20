<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfile
{
    public function handle(Request $request, Closure $next)
    {
        //追記。住所がからでも自由に他のページへ行けるようになる
        return $next($request);

        // 1. ログインしていない場合はチェックをスルー（ログアウトを正常に動作させるため）
        if (!Auth::check()) {
            return $next($request);
        }

        // ★ 追加：メール認証誘導画面（verification.notice）自体のときは何もしない
        if ($request->routeIs('verification.notice')|| 
        $request->routeIs('profile.edit') || 
        $request->routeIs('profile.update') ||
        $request->routeIs('payment.success')){
        return $next($request);
        }

        // ★ 2.5 メール認証がまだ終わっていない場合は、このチェックをスキップする
        // (メール認証ミドルウェアが誘導画面へ飛ばす処理を優先させるため)
        if (!Auth::user()->hasVerifiedEmail()) {
        return $next($request);
        }

        // 3. 住所が未登録の場合の処理
        if (is_null(Auth::user()->postal_code)) {
            
            // プロフィール更新処理(POST)自体は、住所がまだ空の状態で行われるので、許可する
            if ($request->routeIs('profile.update')) {
                return $next($request);
            }

            // 表示画面(GET)以外に行こうとしたら、プロフィール設定画面へ強制リダイレクト
            if (!$request->routeIs('profile.edit')) {
                return redirect()->route('profile.edit');
            }
        }

        return $next($request);
    }
}