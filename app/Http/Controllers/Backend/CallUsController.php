<?php

namespace App\Http\Controllers\Backend;

use Inertia\Inertia;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConnectionRequest;

class CallUsController extends Controller
{
    // 進入聯絡我們頁面
    public function index()
    {
        // 只提供最近六個月的紀錄
        $currentTime = now();
        $sixMonthsAgo = $currentTime->subMonths(6);

        $contact = Contact::where('created_at', '>=', $sixMonthsAgo)->paginate(8);
        return Inertia::render('BackEndFolder/CallUsFolder/CallUs', ['response' => $contact]);
    }
    // 前台送出資料到資料庫
    public function store(ConnectionRequest $request)
    {
        Contact::create([
            'contact_name' => $request->name,
            'contact_tel' => $request->tel,
            'contact_email' => $request->email,
            'contact_main' => $request->main,
            'contact_content' => $request->content,
        ]);
        return back()->with(['message' => '送出成功']);
    }
    // 刪除後台聯絡我們紀錄
    public function delete(Request $request)
    {
        $contact = Contact::find($request->id);
        $contact->delete();
        return back()->with(['message' => '刪除成功']);
    }

    // 搜尋姓名、日期排序
    public function sortData(Request $request)
    {
        // 只提供最近六個月的紀錄
        $currentTime = now();
        $sixMonthsAgo = $currentTime->subMonths(6);

        $queryData = Contact::where('created_at', '>=', $sixMonthsAgo);
        $sort = $request['sort'] ?? 'desc';
        $column = $request['column'] ?? 'created_at';
        $keyword = $request->keyword ?? '';

        //搜尋結果
        if ($keyword) {
            $queryData = Contact::where('contact_name', 'like', '%' . $keyword . '%');
        }

        // 排序過的資料
        $contact = $queryData->orderBy($column, $sort)->paginate(8);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $contact->setPath(route('callus.sortData') . '?column=' . $column . '&sort=' . $sort . '&keyword=' . $keyword);

        return Inertia::render('BackEndFolder/CallUsFolder/CallUs', [
            'response' => $contact,
            'sort' => $sort,
            'column' => $column,
            'returnKeyword' => $keyword,
        ]);
    }
}
