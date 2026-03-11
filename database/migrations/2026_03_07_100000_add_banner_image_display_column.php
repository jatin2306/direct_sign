<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('banners')) {
            return;
        }

        if (Schema::hasColumn('banners', 'image_display')) {
            return;
        }

        DB::statement('ALTER TABLE banners ADD COLUMN image_display JSON NULL AFTER image');
    }

    public function down(): void
    {
        if (Schema::hasColumn('banners', 'image_display')) {
            DB::statement('ALTER TABLE banners DROP COLUMN image_display');
        }
    }
};
