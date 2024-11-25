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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade'); //Sửa lại trường này thêm cascade để thực hiện xóa khi xóa danh mục
            $table->string('name')->nullable(false);
            $table->text('description')->nullable(false);
            $table->integer('duration')->nullable(false);
            $table->float('price')->nullable(false);
            $table->timestamps();
            $table->softDeletes(); // Thêm cột deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
