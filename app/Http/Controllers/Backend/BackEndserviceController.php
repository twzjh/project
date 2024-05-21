<?php

namespace App\Http\Controllers\Backend;

use Throwable;
use App\Models\Cart;
use Inertia\Inertia;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;

class BackEndserviceController extends Controller
{
    public function index()
    {
        $service = Service::paginate(8);

        return Inertia::render('BackEndFolder/ServiceFolder/ServiceContent', ['response' => $service]);
    }

    // 新增
    public function store(Request $request)
    {
        $message = '';

        try {
            Service::create([
            'service_name' => $request->name,
            'service_price' => $request->price,
            'service_introduce' => $request->introduce,
            ]);
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }


        return back()->with(['message' => $message]);
    }

    // 更新
    public function update(Request $request, $id)
    {
        $service = Service::find($id);
        $message = '';

        try {
            $service->update([
            'service_name' => $request->name,
            'service_price' => $request->price,
            'service_introduce' => $request->introduce,
            ]);
            $message = '更新成功';
        } catch (\Throwable $th) {
            $message = '更新失敗';
        }

        return back()->with(['message' => $message]);
    }

    // 刪除
    public function delete($id)
    {
        $service = Service::find($id);
        $service->delete();
        Cart::where('goods_id', $id)->where('goods_type', 1)->delete();
        OrderDetail::where('goods_id', $id)->where('goods_type', 1)->delete();

        return back()->with(['message' => '刪除成功']);
    }
}
