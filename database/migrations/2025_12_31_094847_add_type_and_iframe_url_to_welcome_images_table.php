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
        Schema::table('welcome_images', function (Blueprint $table) {
            $table->string('type')->default('image')->after('id'); // 'image' or 'iframe'
            $table->text('iframe_url')->nullable()->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('welcome_images', function (Blueprint $table) {
            $table->dropColumn(['type', 'iframe_url']);
        });
    }
};
