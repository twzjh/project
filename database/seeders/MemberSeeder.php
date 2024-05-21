<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 找到 ID 為 2 的普通使用者
        $normalUser = User::find(2);

        // 建立會員資料並關聯到普通使用者
        Member::create([
            'user_id' => $normalUser->id,
            'member_status' => 1, // 使用中
            'member_phone' => '123456789',
            'member_birthday' => '2024-01-01',
            'member_birth_time' => '12:00:00',
            'member_city' => '台中市',
            'member_address' => '台中市南區興大路145號',
        ]);
    }
}
