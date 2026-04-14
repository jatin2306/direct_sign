<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_verified_sections', function (Blueprint $table) {
            $table->json('cards')->nullable()->after('intro_text');
        });
    }

    public function down(): void
    {
        Schema::table('home_verified_sections', function (Blueprint $table) {
            $table->dropColumn('cards');
        });
    }
};
