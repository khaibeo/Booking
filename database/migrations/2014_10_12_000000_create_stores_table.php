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
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false)->comment('Tên của cửa hàng');
            $table->string('address')->nullable(false)->comment('Địa chỉ của cửa hàng');
            $table->text('link_map')->nullable()->comment('Liên kết đến vị trí cửa hàng trên bản đồ');
            $table->string('phone')->nullable(false)->comment('Số điện thoại liên hệ của cửa hàng');
            $table->string('image')->nullable(false)->comment('URL hình ảnh của cửa hàng');
            $table->text('description')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
