<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('banners') && ! Schema::hasColumn('banners', 'image_display')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->json('image_display')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('banners', 'image_display')) {
            Schema::table('banners', function (Blueprint $table) {
                $table->dropColumn('image_display');
            });
        }
    }
};
