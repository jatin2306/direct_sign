<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('featured_section_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('featured_section_id')->constrained('featured_sections')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('heading')->nullable();
            $table->string('second_heading')->nullable();
            $table->unsignedTinyInteger('heading_order')->default(1); // 1 = first heading on top, 2 = second heading on top
            $table->string('cta_url', 500)->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_section_images');
    }
};
