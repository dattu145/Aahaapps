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
        Schema::table('pages', function (Blueprint $table) {
            $table->string('meta_description')->nullable()->after('content');
            $table->string('image')->nullable()->after('meta_description');
            $table->string('cta_text')->nullable()->after('image');
            $table->string('cta_url')->nullable()->after('cta_text');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['meta_description', 'image', 'cta_text', 'cta_url']);
        });
    }
};
