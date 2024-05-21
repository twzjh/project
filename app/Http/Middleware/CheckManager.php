<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //拿到現在這個登入的user 1管理員2普通會員
        $user = $request->user();

        if ($user->identify !== 1) {
            return redirect('/');
        };

        return $next($request);
    }
}
