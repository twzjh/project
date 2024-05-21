<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            (object)[
                'service_name' => '印度 占星論命：本命大命',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '印度 占星論命：本命大命',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '印度 占星論命：流年',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '印度 占星論命：流年',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '印度 占星論命：命盤',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '護符製作',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '天星擇日',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '奇門遁甲',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '出生擇日',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
            (object)[
                'service_name' => '風水',
                'service_introduce' => '此符是法師運用祕法、開通祭煉，使得靈符靈奇，特別適用於經商、各類偏財。招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符。',
                'service_price' => 36000,
            ],
        ];
        foreach ($data as $value) {
            Service::create([
                'service_name' => $value->service_name,
                'service_introduce' => $value->service_introduce,
                'service_price' => $value->service_price,
            ]);
        };
    }
}
