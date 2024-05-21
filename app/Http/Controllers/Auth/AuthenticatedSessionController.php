<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**-+
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        //管理者
        if (Auth::User()->identify === 1) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else {
            //普通會員
            //判斷是否由後台登入
            if ($request->from === 'admin') {
                Auth::logout();
                return redirect()->intended(route('mainlogin'));
            } else {
                if (Auth::User()->member->member_status === 2) {
                    Auth::logout();
                    return redirect()->intended(route('mainlogin'))->with('rightStop', '會員已停權')->withInput();
                }
                //正常登入
                return redirect()->intended(RouteServiceProvider::FRONT_INDEX);
            }
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
