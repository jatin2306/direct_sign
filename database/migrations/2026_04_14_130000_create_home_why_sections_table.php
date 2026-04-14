<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_why_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('background_color', 20)->default('#f7fdfb');
            $table->string('heading_color', 20)->default('#26AE61');
            $table->json('cards')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_why_sections');
    }
};
