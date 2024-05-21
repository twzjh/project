<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Course;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword ?? '';
        $services = Service:: where('service_name', 'like', '%' . $keyword . '%')->orWhere('service_introduce', 'like', '%' . $keyword . '%')->get();
        $courses = Course:: where('course_name', 'like', '%' . $keyword . '%')->orWhere('course_introduce', 'like', '%' . $keyword . '%')->get();

        // 購物車裡的課程
        $userId = $request->user()->id ?? null;
        if ($userId) {
            $nowUser = User::with('cart')->find($userId);
            $cartIds = $nowUser->cart()->where('goods_type', 2)->pluck('goods_id')->toArray();
            // 買過的課程
            $goods = Order::with('orderDetail.course')->where('user_id', $userId)->where('order_status', 2)->get();
            $boughtIds = $goods->flatMap(function ($order) {
                return $order->orderDetail
                    ->where('goods_type', 2)
                    ->pluck('goods_id');
            })->toArray();
            $boughtArray = array_merge($cartIds, $boughtIds);
        }

        return Inertia::render('FrontEndFolder/Search', [
            'keyword' => $keyword,
            'serviceFilterData' => $services,
            'courseFilterData' => $courses,
            'boughtArray' => $boughtArray ?? [],
        ]);
    }
}
