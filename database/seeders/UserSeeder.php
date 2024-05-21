<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 建立管理員帳戶
        User::create([
            'name' => 'Admin',
            'email' => 'six666@gmail.com',
            'password' => Hash::make('666666'),
            'identify' => 1,
        ]);

        // 建立普通會員帳戶
        User::create([
            'name' => '普通會員',
            'email' => 'six777@gmail.com',
            'password' => Hash::make('777777'),
            'identify' => 2,
        ]);
    }
}
