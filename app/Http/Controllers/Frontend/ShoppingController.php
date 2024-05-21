<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use Inertia\Response;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class ShoppingController extends Controller
{
    // 進入購物車頁
    public function index(Request $request): Response
    {
        $user = $request->user();
        $id = $user->id;
        $nowUser = User::with('member', 'cart')->find($id);
        // 找此會員購買的服務
        $services = $nowUser->cart()->where('goods_type', 1)->with('service')->get();
        // 找此會員購買的課程
        $courses = $nowUser->cart()->where('goods_type', 2)->with('course')->get();

        return Inertia::render('FrontEndFolder/ShoppingFolder/Shopping', [
            'userData' => $nowUser,
            'serviceData' => $services,
            'courseData' => $courses,
        ]);
    }

    //加入購物車
    public function addCart(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            $message = '請先登入會員';
            return redirect('/mainlogin')->with([
                'message' => $message,
            ]);
        }

        if ($user->identify === 1) {
            $message = '管理員不可購買';
            return back()->with([
                'message' => $message,
            ]);
        }

        $id = $user->id;
        try {
            Cart::create([
                'user_id' => $id,
                'goods_id' => $request['id'],
                'goods_type' => $request['type'],
            ]);
            $message = '加入購物車成功';
        } catch (\Throwable $th) {
            $message = '加入購物車失敗';
        }
        return back()->with([
            'message' => $message,
        ]);
    }

    //移除購物車
    public function deleteGoods(Request $request)
    {
        $goods = Cart::find($request['goodsId']);
        $goods->delete();

        return back();
    }

    // 進入匯款去頁
    public function payment(Request $request): Response
    {
        $id = $request->user()->id;
        $cartCount = Cart::where('user_id', $id)->count();
        $nowUser = User::with('cart')->find($id);
        // 找此會員購買的服務
        $services = $nowUser->cart()->where('goods_type', 1)->with('service')->get();
        // 找此會員購買的課程
        $courses = $nowUser->cart()->where('goods_type', 2)->with('course')->get();


        return Inertia::render('FrontEndFolder/ShoppingFolder/ShoppingPayment', [
            'cartCount' => $cartCount,
            'serviceData' => $services,
            'courseData' => $courses,
        ]);
    }

    //按送出匯款建立訂單表
    public function order(Request $request)
    {
        $userId = $request->user()->id;
        $goodsIdData = $request['detailFrom.goodsId'];
        $typeData = $request['detailFrom.goodsType'];
        $priceData = $request['detailFrom.goodsPrice'];
        $cartData = Cart::where('user_id', $userId)->get();

        //購物車如果有東西才建order
        if (!$cartData->isEmpty()) {
            Order::create([
                'user_id' => $userId,
                'total' => $request['total'],
                'remittance_date' => $request['remitForm.date'],
                'remittance_price' => $request['remitForm.price'],
                'last_number' => $request['remitForm.fiveNum'],
            ]);

            //拿到最新一筆order id
            $latestOrderId = Order::latest()->first()->id;

            //迭代detailData創建OrderDetail資料
            foreach ($goodsIdData as $index => $goodsId) {
                $goodsType = $typeData[$index];
                $goodsPrice = $priceData[$index];

                OrderDetail::create([
                    'order_id' => $latestOrderId,
                    'goods_id' => $goodsId,
                    'goods_type' => $goodsType,
                    'goods_price' => $goodsPrice,
                ]);
            }

            //拿到course id
            $courseIds = OrderDetail::where('order_id', $latestOrderId)->where('goods_type', 2)->pluck('goods_id')->toArray();
            //建立該會員訂單的permissions
            foreach ($courseIds as $goodsId) {
                Permission::create([
                    'user_id' => $userId,
                    'order_id' => $latestOrderId,
                    'course_id' => $goodsId,
                ]);
            }

            //按下送出匯款後清空該會員的購物車
            foreach ($cartData as $cart) {
                $cart->delete();
            }
        }

        return redirect('/member/record');
    }
}
