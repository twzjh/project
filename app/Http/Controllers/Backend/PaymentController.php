<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permission;

class PaymentController extends Controller
{
    // 進入畫面
    public function index()
    {
        $order = Order::with('user', 'orderDetail.service', 'orderDetail.course')->paginate(6);
        return Inertia::render('BackEndFolder/PaymentFolder/Payment', [
            'orderData' => $order,
            'newStatusValue' => 5,
        ]);
    }

    public function edit(Request $request)
    {
        $orderId = $request['orderId'];
        $order = Order::with('user.member', 'orderDetail.service', 'orderDetail.course', 'permission')->find($orderId);
        return Inertia::render('BackEndFolder/PaymentFolder/PaymentEdit', [
            'orderData' => $order,
        ]);
    }
    public function status(Request $request)
    {
        //拿到此用戶的所有order
        $orderId = $request['orderId'];
        $statusNum = $request['statusNum'];
        $order = Order::find($orderId);
        $order->update([
            'order_status' => $statusNum,
        ]);
        return back();
    }
    // 選擇、排序、搜尋功能
    public function sortData(Request $request)
    {
        $queryData = Order::with('user', 'orderDetail.service', 'orderDetail.course');
        $sort = $request['sort'] ?? 'desc';
        $column = $request['column'] ?? 'created_at';
        $orderStatus = $request->status ?? 5;
        $keyword = $request->keyword;

        // 如果有篩選狀態，則加入到查詢條件中
        if ($orderStatus < 5 && !$keyword) {
            $queryData = $queryData->where('order_status', $orderStatus);
        } else {
            $queryData = Order::with('user', 'orderDetail.service', 'orderDetail.course');
        }

        //搜尋結果
        if ($keyword && $orderStatus < 5) {
            $queryData = Order::with('user', 'orderDetail.service', 'orderDetail.course')->whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
            })->where('order_status', $orderStatus);
        } elseif ($keyword) {
            $queryData = Order::with('user', 'orderDetail.service', 'orderDetail.course')->whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
            });
        }

        // 排序過的資料
        $orderData = $queryData->orderBy($column, $sort)->paginate(6);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $orderData->setPath(route('payment.sortData') . '?column=' . $column . '&sort=' . $sort . '&status=' . $orderStatus . '&keyword=' . $keyword);

        return Inertia::render('BackEndFolder/PaymentFolder/Payment', [
            'orderData' => $orderData,
            'sort' => $sort,
            'column' => $column,
            'newStatusValue' => $orderStatus,
            'returnKeyword' => $keyword,
        ]);
    }
    // 儲存匯款資料及課程權限
    public function saveItem(Request $request)
    {
        // 訂單匯款資料
        $orderId = $request->orderId;
        $remittanceDate = $request->remittanceDate;
        $remittancePrice = $request->remittancePrice;
        $lastNumber = $request->lastNumber;
        // 課程權限
        $courseId = $request->courseId;
        $open = $request['open'];
        $editCourse = Permission::where('order_id', $orderId)->where('course_id', $courseId)->first();
        $editRemittance = Order::where('id', $orderId)->first();
        $message = '';
        try {
            $editRemittance->update([
                'remittance_date' => $remittanceDate,
                'remittance_price' => $remittancePrice,
                'last_number' => $lastNumber,
            ]);
            if($courseId) {
                $editCourse->update([
                    'permission' => $open,
                ]);
            }
            $message = '成功';
        } catch (\Throwable $th) {
            $message = '失敗';
        }
        return back()->with([
            'message' => $message,
        ]);
    }
}
