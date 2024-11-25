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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained()->comment('ID cửa hàng');
            $table->foreignId('user_id')->nullable()->constrained()->comment('Nhân viên tạo hóa đơn');
            $table->string('name')->comment('Tên khách hàng');
            $table->string('phone')->comment('Số điện thoại khách hàng');
            $table->integer('total_amount')->comment('Tổng tiền');
            $table->enum('payment_method', ['cash', 'transfer'])->comment('Phương thức thanh toán: tiền mặt hoặc chuyển khoản');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
