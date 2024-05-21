<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;
use Illuminate\Http\Request;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $request->user(),
            ],
            'ziggy' => fn () => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
                'query' => count($request->query()) ? $request->query() : (object)[],
                'previous' => url()->previous(),
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
                'orderData' => fn () => $request->session()->get('orderData'),
                'position' => fn () => $request->session()->get('position'),
            ],
            'cart' => [
                'count' => Cart::where('user_id', $request->user()->id ?? '')->get()->count() ,
            ],
        ];
    }
}
