<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 取得登入者資料
        $user = $request->user();

        // 沒登入會到前台會員登入頁
        if (!$user) {
            return redirect(route('mainlogin'));
        };

        // 登入不是普通會員的話會到後台登入頁
        if ($user->identify !== 2) {
            return redirect('login');
        };

        return $next($request);
    }
}
