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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('store_id')->constrained();
            $table->string('name')->nullable(false);
            $table->string('phone')->nullable(false);
            $table->date('booking_date')->nullable(false);
            $table->time('booking_time')->nullable(false);
            $table->time('end_time')->nullable(false);
            $table->text('note')->nullable();
            $table->integer('total_amount')->nullable(false);
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
