<?php

namespace App\Http\Controllers\Backend;

use App\Models\Cart;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Chapter;
use function Psy\debug;
use App\Models\OrderDetail;

use Illuminate\Http\Request;
use App\Services\FilesService;
use App\Http\Controllers\Controller;

class BackEndCourseController extends Controller
{
    public function index()
    {
        $course = Course::paginate(8);

        return Inertia::render('BackEndFolder/CourseFolder/SonCourseContent', ['response' => $course]);
    }

    public function addSonCourse()
    {
        $course = Course::get();

        return Inertia::render('BackEndFolder/CourseFolder/AddSonCourse', ['response' => $course]);
    }

    public function editSonCourse($id)
    {
        $course = Course::find($id);
        $mainCount = Course::where('course_main', 2)->count();
        $chapters = Chapter::where('course_id', $id)->get();
        $courseImg = $course->course_image;

        return Inertia::render('BackEndFolder/CourseFolder/EditSonCourse', [
            'response' => $course,
            'chapters' => $chapters,
            'mainCount' => $mainCount,
            'courseImg' => $courseImg,
        ]);
    }

    // 新增
    public function store(Request $request, FilesService $filesService)
    {
        $photo = $request->photo;

        $path = '';
        if ($photo) {
            $path = $filesService->uploadImg($photo);
        }

        try {
            $course = Course::create([
            'course_name' => $request->name,
            'course_type' => $request->type,
            'course_main' => $request->main,
            'course_price' => $request->price,
            'course_hour' => $request->hour,
            'course_introduce' => $request->introduce,
            'detail_introduce' => $request->detailIntroduce,
            'course_image' => $path,
            ]);
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
            return redirect(route('soncourse.content'))->with(['message' => $message]);
        }

        return redirect(route('editsoncourse', ['id' => $course->id ?? 0]))->with(['message' => $message]);
    }

    // 更新
    public function update(Request $request, $id, FilesService $filesService)
    {

        $course = Course::find($id);
        $photo = $request->photo;
        // 處理圖片的上傳
        if ($photo) {
            // 呼叫上傳圖片的函式，並回傳路徑
            $path = $filesService->uploadImg($photo);

            // 呼叫FilesService的deleteFile去刪除檔案
            $filesService->deleteFile($course->course_image);
        } else {
            $path = $course->photo;
        }

        if ($request->main === 1) {
            $filesService->deleteFile($course->course_image);
            $course->update([
                'course_main' => $request->main,
                'course_image' => null,
            ]);
        }

        try {
            if ($photo === '') {
                $course->update([
                'course_name' => $request->name,
                'course_type' => $request->type,
                'course_main' => $request->main,
                'course_price' => $request->price,
                'course_hour' => $request->hour,
                'course_introduce' => $request->introduce,
                'detail_introduce' => $request->detailIntroduce,
                ]);
            } else {
                $course->update([
                    'course_main' => $request->main,
                    'course_image' => $path,
                ]);
            }
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }

        return redirect(route('soncourse.content'))->with(['message' => $message]);
    }

    // 刪除
    public function delete($id, FilesService $filesService)
    {
        $course = Course::find($id);
        $course->delete();
        Cart::where('goods_id', $id)->where('goods_type', 2)->delete();
        OrderDetail::where('goods_id', $id)->where('goods_type', 2)->delete();

        $chapters = Chapter::where('course_id', $id);
        $chapters->delete();

        $filesService->deleteFile($course->course_image);

        return back()->with(['message' => '刪除成功']);
    }

    // 課程排序
    public function sortData(Request $request)
    {
        $sort = $request['sort'];
        $column = $request['column'];
        // 排序過的資料
        $orderData = Course::orderBy($column, $sort)->paginate(8);
        // 排序過的資料並且讓分頁器的url都帶排列欄位&sort類型
        $orderData->setPath(route('course.sortData') . '?column=' . $column . '&sort=' . $sort);

        return Inertia::render('BackEndFolder/CourseFolder/SonCourseContent', [
            'response' => $orderData,
            'sort' => $sort,
            'column' => $column,
        ]);
    }
}
