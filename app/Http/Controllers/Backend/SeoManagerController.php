<?php

namespace App\Http\Controllers\Backend;

use App\Models\Seo;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SeoManagerController extends Controller
{
    public function index()
    {
        $seo = Seo::latest()->first();

        return Inertia::render('BackEndFolder/SeoFolder/Seo-manage', ['seo' => $seo]);
    }

    // 新增修改
    public function store(Request $request)
    {
        $lastSeo = Seo::latest()->first();

        if ($lastSeo) {
            $lastSeo->update([
                'seo_title' => $request->seo_title,
                'seo_keyword' => $request->seo_keyword,
                'seo_description' => $request->seo_description,
            ]);

            return back()->with(['message' => '修改成功']);
        } else {
            Seo::create([
                'seo_title' => $request->seo_title,
                'seo_keyword' => $request->seo_keyword,
                'seo_description' => $request->seo_description,
            ]);
            return back()->with(['message' => '新增成功']);
        }
    }
}
