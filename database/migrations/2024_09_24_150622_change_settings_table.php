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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('logo')->nullable()->change();
            $table->text('slogan')->nullable()->change();
            $table->string('contact_phone')->nullable()->change();
            $table->string('contact_email')->nullable()->change();
            $table->string('facebook')->nullable()->change();
            $table->string('messenger')->nullable();
            $table->string('instagram')->nullable()->change();
            $table->string('linkedin')->nullable();
            $table->string('zalo')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('youtube')->nullable()->change();
            $table->dropColumn('lindin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('logo')->nullable(false)->change();
            $table->text('slogan')->nullable(false)->change();
            $table->string('contact_phone')->nullable(false)->change();
            $table->string('contact_email')->nullable(false)->change();
            $table->string('facebook')->nullable(false)->change();
            $table->string('instagram')->nullable(false)->change();
            $table->string('youtube')->nullable(false)->change();

            $table->dropColumn('messenger');
            $table->dropColumn('linkedin');
            $table->dropColumn('zalo');
            $table->dropColumn('tiktok');

            $table->string('lindin')->nullable();
        });
    }
};
