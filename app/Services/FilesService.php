<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class FilesService
{
    // 上傳圖片檔
    public function uploadImg($file)
    {
        // 檢查是否有upload資料夾，如果沒有時建立一個upload資料夾
        if (!is_dir('upload/')) {
            mkdir('upload/');
        }

        // 拿到副檔名
        $extension = $file->extension();

        // 拿到檔案名稱
        $fileName = $file->hashName();

        // 切割出來的唯一值名稱
        $spliteName = explode('.', $fileName)[0];

        // 組成檔案路徑
        $path = '/upload/' . $spliteName . '.' . $extension;

        // 將文件存入指定路徑
        move_uploaded_file($file, public_path() . $path);

        return $path;
    }

    // 刪除檔案
    public function deleteFile($path)
    {
        // 如果原本檔案確實存在，則刪除原本的檔案
        if (file_exists(public_path() . $path)) {
            File::delete(public_path() . $path);
        }

        return true;
    }
}
