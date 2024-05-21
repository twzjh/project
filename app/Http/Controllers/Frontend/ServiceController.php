<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Course;
use App\Models\Service;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = Service::get();
        $courses = Course::get();

        $userId = $request->user()->id ?? null;
        if ($userId) {
            $nowUser = User::with('cart')->find($userId);
            // 購物車裡的服務
            $cartServiceIds = $nowUser->cart()->where('goods_type', 1)->pluck('goods_id')->toArray();
            // 購物車裡的課程
            $cartIds = $nowUser->cart()->where('goods_type', 2)->pluck('goods_id')->toArray();
            // 買過的課程
            $goods = Order::with('orderDetail.course')->where('user_id', $userId)->whereNotIn('order_status', [4])->get();
            $boughtIds = $goods->flatMap(function ($order) {
                return $order->orderDetail
                    ->where('goods_type', 2)
                    ->pluck('goods_id');
            })->toArray();
            $boughtArray = array_merge($cartIds, $boughtIds);
        }

        return Inertia::render('FrontEndFolder/Services', [
            'serviceData' => $services,
            'courseData' => $courses,
            'boughtArray' => $boughtArray ?? [],
            'boughtService' => $cartServiceIds ?? [],
        ]);
    }
    // 課程介紹頁面
    public function show(Request $request)
    {
        // 取得章節後渲染前台
        $courses = Course::with('chapter')->find($request->courseId);
        $userId = $request->user()->id ?? null;
        if ($userId) {
            $nowUser = User::with('cart')->find($userId);
            // 購物車裡的課程
            $cartIds = $nowUser->cart()->where('goods_type', 2)->pluck('goods_id')->toArray();
            // 買過的課程
            $goods = Order::with('orderDetail.course')->where('user_id', $userId)->whereNotIn('order_status', [4])->get();
            $boughtIds = $goods->flatMap(function ($order) {
                return $order->orderDetail
                    ->where('goods_type', 2)
                    ->pluck('goods_id');
            })->toArray();
            $boughtArray = array_merge($cartIds, $boughtIds);
        }
        // 購買過的課程可以打開影片
        $chapter = Permission::with('course.chapter')->where('user_id', $userId)->where('course_id', $courses->id)->where('permission', 2)->get();
        // dd($chapter);
        return Inertia::render('FrontEndFolder/Coursecontent', [
            'courses' => $courses,
            'chapter' => $chapter,
            'boughtArray' => $boughtArray ?? [],
        ]);
    }
}
