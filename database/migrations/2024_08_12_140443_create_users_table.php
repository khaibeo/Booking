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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained();
            $table->string('name')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('image')->nullable();
            $table->string('phone')->unique()->nullable(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable(false);
            $table->enum('role', ['manager', 'staff', 'cashier'])->nullable(false);
            $table->tinyInteger('expired')->nullable(false)->default(0);
            $table->string('biography');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
