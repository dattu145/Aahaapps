<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('welcome_images', function (Blueprint $table) {
            $table->string('target_url')->nullable()->after('image_path');
            $table->integer('opacity')->default(100)->after('target_url'); // 0 to 100
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('welcome_images', function (Blueprint $table) {
            $table->dropColumn(['target_url', 'opacity']);
        });
    }
};
