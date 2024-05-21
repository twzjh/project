<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class MemberManagementController extends Controller
{
    // 會員管理首頁
    public function index(Request $request)
    {
        $memberData = Member::with('user')->orderBy('id')->paginate(8);
        return Inertia::render('BackEndFolder/MemberFolder/Member-management', [
            'memberData' => $memberData,
            'jumpNow' => $request->jumpNow ?? 0,
        ]);
    }

    // 選擇、排序、搜尋功能
    public function sortMember(Request $request)
    {
        $queryData = Member::with('user');
        $sort = $request['sort'] ?? 'asc';
        $column = $request['column'] ?? 'id';
        $keyword = $request->keyword;

        //搜尋結果
        if ($keyword) {
            $queryData = Member::with('user')->whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
            })->orWhere('member_phone', 'like', '%' . $keyword . '%');
        } else {
            $queryData = Member::with('user');
        }

        // 排序過的資料
        $memberData = $queryData->orderBy($column, $sort)->paginate(8);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $memberData->setPath(route('backmember.sortMember') . '?column=' . $column . '&sort=' . $sort . '&keyword=' . $keyword);

        return Inertia::render('BackEndFolder/MemberFolder/Member-management', [
            'memberData' => $memberData,
            'sort' => $sort,
            'column' => $column,
            'returnKeyword' => $keyword,
        ]);
    }

    // 新增會員
    public function addMember(UserRequest $request)
    {
        $message = '';
        try {
            User::create(
                [
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                ]
            );

            $userId = User::latest()->first()->id;
            Member::create([
                'user_id' => $userId,
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

    // 刪除會員
    public function delete(Request $request)
    {
        $user = User::find($request['userId']);
        $user->member()->delete();
        $user->delete();

        return back();
    }

    // 會員購買紀錄
    public function record(Request $request)
    {
        $userId = $request['userId'];
        $userData = User::find($userId);
        $orderData = Order::with('orderDetail.service', 'orderDetail.course')->where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(4);
        $orderData->setPath(route('backmember.record') . '?userId=' . $userId);
        return Inertia::render('BackEndFolder/MemberFolder/Member-management2', [
            'userData' => $userData,
            'orderData' => $orderData,
        ]);
    }

    // 購買紀錄排序
    public function sortData(Request $request)
    {
        $userId = $request['userId'];
        $sort = $request['sort'];
        $column = $request['column'];
        $userData = User::find($userId);
        // 排序過的資料
        $orderData = Order::with('orderDetail.service', 'orderDetail.course')->where('user_id', $userId)->orderBy($column, $sort)->paginate(4);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $orderData->setPath(route('backmember.sortData') . '?userId=' . $userId . '&column=' . $column . '&sort=' . $sort);

        return Inertia::render('BackEndFolder/MemberFolder/Member-management2', [
            'userData' => $userData,
            'orderData' => $orderData,
            'sort' => $sort,
            'column' => $column,
        ]);
    }

    // 查看/編輯會員
    public function edit(Request $request)
    {
        $userData = User::with('member')->find($request['userId']);
        return Inertia::render('BackEndFolder/MemberFolder/Member-management3', [
            'userData' => $userData,
        ]);
    }

    // 修改會員資料
    public function editupdae(Request $request)
    {
        $user = User::find($request['id']);
        $message = '';
        try {
            $user->update([
                'name' => $request['name'],
                'email' => $request['email'],
            ]);
            $user->member->update([
                'member_status' => $request['status'],
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
}
