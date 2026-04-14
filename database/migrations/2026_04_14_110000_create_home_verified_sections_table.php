<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_verified_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->text('intro_text')->nullable();
            $table->string('item_1_title')->nullable();
            $table->text('item_1_description')->nullable();
            $table->string('item_2_title')->nullable();
            $table->text('item_2_description')->nullable();
            $table->string('item_3_title')->nullable();
            $table->text('item_3_description')->nullable();
            $table->string('item_4_title')->nullable();
            $table->text('item_4_description')->nullable();
            $table->text('footer_text')->nullable();
            $table->string('heading_color', 20)->default('#26AE61');
            $table->string('text_color', 20)->default('#4A225B');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_verified_sections');
    }
};
