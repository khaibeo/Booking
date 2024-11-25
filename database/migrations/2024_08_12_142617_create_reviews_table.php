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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable(false)->constrained();
            // $table->foreignId('user_id')->nullable(false)->constrained();
            $table->string('name')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->tinyInteger('rating')->nullable(false);
            $table->text('comment')->nullable(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
