<?php

use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\FrontpageController;
use App\Http\Controllers\Backend\CallUsController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\ServiceController;
use App\Http\Controllers\Frontend\ShoppingController;
use App\Http\Controllers\Auth\RegisteredUserController;

//首頁
Route::get('/', [FrontpageController::class, 'index'])->name('frontpage');

//課程介紹內容
Route::get('/coursecontent', [ServiceController::class, 'show'])->name('coursecontent');

//服務與課程頁
Route::get('/services', [ServiceController::class, 'index'])->name('services');
Route::post('/addCart', [ShoppingController::class, 'addCart'])->name('addCart');

//前台登入/註冊
Route::get('/mainlogin', function () {
    return Inertia::render('FrontEndFolder/Login');
})->name('mainlogin');

//忘記密碼 (原生修改完成)
// Route::get('/forget', function () {
//     return Inertia::render('FrontEndFolder/Forget');
// });

//修改密碼 (原生修改完成)
// Route::get('/revise', function () {
//     return Inertia::render('FrontEndFolder/Revisepass');
// })->name('revise');

//會員中心頁
Route::group(['prefix' => 'member', 'middleware' => ['auth', 'memberpage']], function () {
    Route::get('/', [MemberController::class, 'edit'])->name('member.edit');
    Route::post('/profileEdit', [MemberController::class, 'profileEdit']);
    Route::post('/passwordEdit', [MemberController::class, 'password'])->name('member.passwordEdit');
    Route::get('/courses', [MemberController::class, 'courses'])->name('member.courses');
    Route::get('/record', [MemberController::class, 'record'])->name('member.record');
    Route::get('/sortData', [MemberController::class, 'sortData'])->name('record.sortData');
});

//付款政策
Route::get('/paymentTerms', function () {
    return Inertia::render('FrontEndFolder/PaymentTerms');
});

//隱私權政策
Route::get('/privacy', function () {
    return Inertia::render('FrontEndFolder/Privacy');
});


//聯絡我們
Route::get('/connection', function () {
    return Inertia::render('FrontEndFolder/Connection');
});
// 前台聯絡我們送到資料庫
Route::post('/add-connection', [CallUsController::class, 'store']);

//搜尋頁
Route::get('/search', [SearchController::class, 'index'])->name('search');

//購物車頁
Route::group(['prefix' => 'shopping', 'middleware' => ['auth', 'memberpage']], function () {
    Route::get('/', [ShoppingController::class, 'index'])->name('shopping.index');
    Route::post('/delete', [ShoppingController::class, 'deleteGoods'])->name('shopping.delete');
    Route::get('/payment', [ShoppingController::class, 'payment'])->name('shopping.payment');
    Route::post('/addOrder', [ShoppingController::class, 'order'])->name('shopping.order');
});

//課程影片
Route::get('/video', function () {
    return Inertia::render('FrontEndFolder/video');
});
