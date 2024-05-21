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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('contact_name', 50)->comment('姓名');
            $table->string('contact_tel')->comment('手機號碼');
            $table->string('contact_email')->comment('電子郵件');
            $table->string('contact_main', 20)->comment('主旨');
            $table->text('contact_content')->comment('內容');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
