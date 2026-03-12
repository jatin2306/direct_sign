<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('featured_sections', function (Blueprint $table) {
            $table->string('type', 20)->default('properties')->after('id'); // 'properties' | 'developers'
        });

        Schema::create('featured_section_developers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('featured_section_id')->constrained('featured_sections')->cascadeOnDelete();
            $table->string('name');
            $table->string('logo_text')->nullable();
            $table->boolean('logo_dark')->default(false);
            $table->string('search_slug')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_section_developers');
        Schema::table('featured_sections', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
