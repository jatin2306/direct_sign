<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_sales_sections', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('heading_highlight')->nullable();
            $table->string('section_background_color', 20)->default('#ffffff');
            $table->string('heading_color', 20)->default('#26AE61');
            $table->string('heading_highlight_color', 20)->default('#4A225B');
            $table->string('box_background_color', 20)->default('#f7fdfb');
            $table->string('box_border_color', 20)->default('#26AE61');
            $table->string('step_title_color', 20)->default('#26AE61');
            $table->json('steps')->nullable();
            $table->text('bottom_note')->nullable();
            $table->text('bottom_note_subtext')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_sales_sections');
    }
};
