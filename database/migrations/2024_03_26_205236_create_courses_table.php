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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('course_name', 10)->comment('課程名稱');
            $table->integer('course_type')->comment('課程類別(1吠陀占星、2中醫、3古典魔法、4其他術數)');
            $table->integer('course_price')->comment('價格');
            $table->string('course_introduce', 36)->comment('課程介紹');
            $table->text('detail_introduce', 500)->comment('詳細介紹');
            $table->longText('course_image')->nullable()->comment('主打課程圖片');
            $table->integer('course_hour')->comment('單堂時數');
            $table->integer('course_main')->default(1)->comment('主打課程(1普通、2主打(最多兩個)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
