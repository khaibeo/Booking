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
        Schema::table('bookings', function (Blueprint $table) {
            // Xóa ràng buộc khóa ngoại
            $table->dropForeign(['user_id']);

            // Thay đổi cột để cho phép null
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Thêm lại ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Xóa ràng buộc khóa ngoại
            $table->dropForeign(['user_id']);

            // Thay đổi cột để không cho phép null
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            // Thêm lại ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users');
        });
    }
};
