<?php

namespace Database\Seeders;

use App\Models\Seo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SeoSeeder extends Seeder
{
    public function run(): void
    {
        Seo::create([
            'seo_title' => '五術研究社',
            'seo_keyword' => '中醫、占星、古典魔法、奇門遁甲、護符、風水、其他術數、祕法、財運',
            'seo_description' => '特別適用於經商、各類偏財。...招財符超靈驗法師開光靈符買家見證有效開財庫聚財運開運桃花五方貴人文昌破小人護身符',
        ]);
    }
}
