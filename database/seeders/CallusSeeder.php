<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\Cast\Object_;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CallusSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            (Object) [
                'contact_name' => '王曉明',
                'contact_tel' => '0972334581',
                'contact_email' => 'ming123@gmail.com',
                'contact_main' => '課程旁聽',
                'contact_content' => '請問有課程可以試聽或是體驗?',
            ],
            (Object) [
                'contact_name' => '林桐龍',
                'contact_tel' => '0912834496',
                'contact_email' => 'tong123@gmail.com',
                'contact_main' => '服務退費',
                'contact_content' => '請問服務尚未有時間可以做使用，可以申請退費?',
            ],
        ];

        foreach ($data as $value) {
            Contact::create([
                'contact_name' => $value->contact_name,
                'contact_tel' => $value->contact_tel,
                'contact_email' => $value->contact_email,
                'contact_main' => $value->contact_main,
                'contact_content' => $value->contact_content,
            ]);
        };
    }
}
