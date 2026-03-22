<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckProfile
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);

        if (!Auth::check()) {
            return $next($request);
        }

        if ($request->routeIs('verification.notice')||
        $request->routeIs('profile.edit') ||
        $request->routeIs('profile.update') ||
        $request->routeIs('payment.success')){
        return $next($request);
        }

        if (!Auth::user()->hasVerifiedEmail()) {
        return $next($request);
        }

        if (is_null(Auth::user()->postal_code)) {

            if ($request->routeIs('profile.update')) {
                return $next($request);
            }

            if (!$request->routeIs('profile.edit')) {
                return redirect()->route('profile.edit');
            }
        }

        return $next($request);
    }
}
