<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CallUsController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\SeoManagerController;
use App\Http\Controllers\Backend\ChapterController;
use App\Http\Controllers\Backend\BackEndCourseController;
use App\Http\Controllers\Backend\BackEndserviceController;
use App\Http\Controllers\Backend\MemberManagementController;

Route::middleware(['auth','check.manager'])->prefix('/admin')->group(function () {
    Route::get('/', [PaymentController::class, 'index']);

    // 付款畫面
    Route::prefix('payment')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/sortData', [PaymentController::class, 'sortData'])->name('payment.sortData');
        Route::get('/edit', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::get('/status', [PaymentController::class, 'status'])->name('payment.status');
        Route::post('/editPermission', [PaymentController::class, 'permission'])->name('payment.permission');
        Route::post('/edit', [PaymentController::class, 'saveItem'])->name('payment.saveItem');
    });

    // 後台服務內容管理
    Route::group(['prefix' => 'service'], function () {
        Route::get('/', [BackEndserviceController::class, 'index'])->name('service.content');
        Route::post('/store', [BackEndserviceController::class, 'store'])->name('service.store');
        Route::post('/edit/{id}', [BackEndserviceController::class, 'edit'])->name('service.edit');
        Route::post('/update/{id}', [BackEndserviceController::class, 'update'])->name('service.update');
        Route::post('/delete/{id}', [BackEndserviceController::class, 'delete'])->name('service.delete');
    });

    // 後台子課程管理
    Route::group(['prefix' => 'soncourse'], function () {
        Route::get('/', [BackEndCourseController::class, 'index'])->name('soncourse.content');
        Route::get('/add', [BackEndCourseController::class, 'addSonCourse'])->name('addsoncourse');
        Route::get('/edit/{id}', [BackEndCourseController::class, 'editSonCourse'])->name('editsoncourse');
        Route::post('/coursestore', [BackEndCourseController::class, 'store'])->name('course.store');
        Route::post('/courseupdate/{id}', [BackEndCourseController::class, 'update'])->name('course.update');
        Route::get('/coursedelete/{id}', [BackEndCourseController::class, 'delete'])->name('course.delete');
        Route::get('/courseSort', [BackEndCourseController::class, 'sortData'])->name('course.sortData');
        // 章節controller
        Route::post('/chapterstore', [ChapterController::class, 'store'])->name('chapter.store');
        Route::post('/chapterupdate/{id}', [ChapterController::class, 'update'])->name('chapter.update');
        Route::delete('/chapterdelete/{id}', [ChapterController::class, 'delete'])->name('chapter.delete');
    });

    Route::get('/Seo-manage', [SeoManagerController::class,'index'])->name('seo.manage');

    Route::post('/seo-store', [SeoManagerController::class,'store'])->name('seo.store');

    // 後台會員管理
    Route::group(['prefix' => 'Member-management'], function () {
        Route::get('/', [MemberManagementController::class,'index'])->name('member.manage');
        Route::post('/addMember', [MemberManagementController::class,'addMember'])->name('member.addMember');
        Route::get('/sortMember', [MemberManagementController::class,'sortMember'])->name('backmember.sortMember');
        Route::get('/search', [MemberManagementController::class,'search'])->name('backmember.search');
        Route::post('/delete', [MemberManagementController::class,'delete'])->name('backmember.delete');
        Route::get('/record', [MemberManagementController::class,'record'])->name('backmember.record');
        Route::get('/sortData', [MemberManagementController::class,'sortData'])->name('backmember.sortData');
        Route::get('/edit', [MemberManagementController::class,'edit'])->name('backmember.edit');
        Route::post('/editupdae', [MemberManagementController::class,'editupdae'])->name('backmember.editupdae');
    });

    // 聯絡我們
    Route::prefix('callus')->group(function () {
        Route::get('/', [CallUsController::class, 'index'])->name('callus.index');
        Route::post('/delete', [CallUsController::class, 'delete'])->name('callus.delete');
        Route::get('/sortData', [CallUsController::class, 'sortData'])->name('callus.sortData');
    });
});

// 後台-忘記密碼
Route::get('/back_forget', function () {
    return Inertia::render('BackEndFolder/LoginFolder/Backforget');
});

// 後台-修改密碼
Route::get('/back_Revise', function () {
    return Inertia::render('BackEndFolder/LoginFolder/Backrevisepass');
});
