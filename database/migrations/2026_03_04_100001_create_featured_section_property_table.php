<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('featured_section_property', function (Blueprint $table) {
            $table->id();
            $table->foreignId('featured_section_id')->constrained('featured_sections')->cascadeOnDelete();
            $table->foreignId('property_id')->constrained('properties')->cascadeOnDelete();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->unique('property_id'); // each property can only be in one section
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_section_property');
    }
};
