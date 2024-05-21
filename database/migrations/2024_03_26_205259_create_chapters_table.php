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
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->integer('course_id')->comment('課程id');
            $table->string('chapter_name', 16)->comment('章節名稱');
            $table->integer('chapter_number')->comment('排序');
            $table->string('chapter_introduce', 40)->comment('章節簡介');
            $table->longText('chapter_video')->comment('課程影片');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};
