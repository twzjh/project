<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Inertia\Inertia;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;

class FrontpageController extends Controller
{
    public function index(Request $request)
    {
        // 頁籤分頁
        $type = 1;
        if ($request->tab) {
            $type = $request->tab;
        };
        $courseMain = Course::where('course_main', 2)->get();
        $coursesData = Course::where('course_type', $type)->paginate(6);
        $coursesData->setPath(route('frontpage') . '?tab=' . $type);
        foreach ($coursesData as $course) {
            // 取得該課程的章節數量
            $chapterCount = Chapter::where('course_id', $course->id)->count();

            // 將章節數量存儲到課程物件中
            $course->chapterCount = $chapterCount;
        }
        return Inertia::render('FrontEndFolder/Frontpage', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'coursesData' => $coursesData,
        'courseMain' => $courseMain,
        ]);
    }
}
