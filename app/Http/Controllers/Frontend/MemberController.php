<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\passwordRequest;

class MemberController extends Controller
{
    // 進入編輯頁
    public function edit(Request $request): Response
    {
        $user = $request->user();
        $id = $user->id;

        $user = User::with('member')->find($id);
        return Inertia::render('FrontEndFolder/MemberFolder/Edit', [
            'userData' => $user,
        ]);
    }

    //進行編輯動作
    public function profileEdit(Request $request)
    {
        $user = User::find($request['id']);
        $message = '';
        try {
            $user->update([
                'name' => $request['name'],
            ]);
            $user->member->update([
                'member_phone' => $request['phone'],
                'member_birthday' => $request['birthday'],
                'member_birth_time' => $request['birthTime'],
                'member_city' => $request['birthCity'],
                'member_address' => $request['address'],
            ]);
            $message = '成功';
        } catch (\Throwable $th) {
            $message = '失敗';
        }
        return back()->with([
            'message' => $message,
        ]);
    }

    // 更改密碼
    public function password(passwordRequest $request)
    {
        $message = '';
        try {
            $request->user()->update([
                'password' => Hash::make($request['password']),
            ]);
            $message = '成功';
        } catch (\Throwable $th) {
            $message = '失敗';
        }
        return back()->with([
            'message' => $message,
        ]);
    }

    // 進入課程頁
    public function courses(Request $request)
    {
        // 找此會員下單&已付款(order_status:2)的課程
        $userId = $request->user()->id;
        $goods = Order::with('orderDetail.course')->where('user_id', $userId)->where('order_status', 2)->get();

        // 獲取買過的課程id轉換為陣列
        $courseIds = $goods->flatMap(function ($order) {
            return $order->orderDetail
                ->where('goods_type', 2)
                ->pluck('goods_id');
        })->toArray();
        // 返回符合條件的課程集合
        $courseData = Course::whereIn('id', $courseIds)->get();

        return Inertia::render('FrontEndFolder/MemberFolder/Courses', [
            'courseData' => $courseData,
        ]);
    }

    // 進入購買紀錄頁
    public function record(Request $request)
    {
        $userId = $request->user()->id;
        // 只提供最近六個月的訂單預覽
        $currentTime = now();
        $sixMonthsAgo = $currentTime->subMonths(6);
        //拿到此用戶的所有order
        $orderData = Order::with('orderDetail.service', 'orderDetail.course')->where('user_id', $userId)->where('created_at', '>=', $sixMonthsAgo)->orderBy('created_at', 'desc')->paginate(6);
        return Inertia::render('FrontEndFolder/MemberFolder/Record', [
            'orderData' => $orderData,
        ]);
    }

    // 購買紀錄頁訂單排序
    public function sortData(Request $request)
    {
        // 只提供最近六個月的訂單預覽
        $currentTime = now();
        $sixMonthsAgo = $currentTime->subMonths(6);

        $userId = $request->user()->id;
        $sort = $request['sort'];
        $column = $request['column'];
        // 排序過的資料
        $orderData = Order::with('orderDetail.service', 'orderDetail.course')->where('user_id', $userId)->where('created_at', '>=', $sixMonthsAgo)->orderBy($column, $sort)->paginate(6);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $orderData->setPath(route('record.sortData') . '?column=' . $column . '&sort=' . $sort);

        return Inertia::render('FrontEndFolder/MemberFolder/Record', [
            'orderData' => $orderData,
            'sort' => $sort,
            'column' => $column,
        ]);
    }
}
