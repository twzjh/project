<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        //註冊內容
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'member_phone' => 'required|string|max:10',
            'member_birthday' => 'required|date',
            'member_birth_time' => 'required|string',
            'member_city' => 'required|string|max:50',
            'member_address' => 'required|string|max:255',
        ]);
        //新增普通會員
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'identify' => 2,
        ]);

        if ($user) {
             Member::create([
                'user_id' => $user->id,
                'member_status' => 1,
                'member_phone' => $request->member_phone,
                'member_birthday' => $request->member_birthday,
                'member_birth_time' => $request->member_birth_time,
                'member_city' => $request->member_city,
                'member_address' => $request->member_address,
             ]);
        };

        event(new Registered($user));

        Auth::login($user);

        if ($user->identify === 1) {
            return redirect(RouteServiceProvider::HOME);
        } else {
            return redirect(RouteServiceProvider::FRONT_INDEX);
        }
    }
}
