<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('帳號id');
            $table->integer('member_status')->default(1)->comment('會員狀態(1使用中、2停權)');
            $table->string('member_phone')->comment('電話');
            $table->date('member_birthday')->comment('出生日期');
            $table->time('member_birth_time')->comment('出生時間');
            $table->string('member_city')->comment('出生城市');
            $table->string('member_address')->comment('地址');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
