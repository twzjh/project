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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('帳號id');
            $table->integer('order_status')->default(1)->comment('訂單狀態(1訂單成立、2確認收款、3尚未付款、4訂單取消)');
            $table->integer('total')->comment('金額總計');
            $table->dateTime('remittance_date')->comment('匯款日期');
            $table->integer('remittance_price')->comment('匯款金額');
            $table->integer('last_number')->comment('帳號後5碼');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
