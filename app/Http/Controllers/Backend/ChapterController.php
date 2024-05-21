<?php

namespace App\Http\Controllers\Backend;

use App\Models\Chapter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChapterController extends Controller
{
    public function store(Request $request)
    {
        try {
            Chapter::create([
            'course_id' => $request->courseId,
            'chapter_name' => $request->chapterName,
            'chapter_number' => $request->chapterNum,
            'chapter_introduce' => $request->chapterIntroduce,
            'chapter_video' => $request->chapterVideo,
            ]);
            $message = '新增成功';
        } catch (\Throwable $th) {
            $message = '新增失敗';
        }

        return back()->with(['message' => $message]);
    }

    public function update(Request $request, $id)
    {
        $chapter = Chapter::find($id);

        try {
            $chapter->update([
            'chapter_name' => $request->chapterName,
            'chapter_number' => $request->chapterNum,
            'chapter_introduce' => $request->chapterIntroduce,
            'chapter_video' => $request->chapterVideo,
            ]);
            $message = '更新成功';
        } catch (\Throwable $th) {
            $message = '更新失敗';
        }

        return back()->with(['message' => $message]);
    }

    public function delete($id)
    {
        $chapter = Chapter::find($id);
        $chapter->delete();

        return back()->with(['message' => '刪除成功']);
    }
}
