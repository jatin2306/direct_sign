<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('home_sales_sections', function (Blueprint $table) {
            $table->string('bottom_note_prefix')->nullable()->after('bottom_note');
            $table->string('bottom_note_highlight')->nullable()->after('bottom_note_prefix');
            $table->string('bottom_note_suffix')->nullable()->after('bottom_note_highlight');
            $table->string('bottom_note_text_color', 20)->default('#212529')->after('bottom_note_suffix');
            $table->string('bottom_note_highlight_color', 20)->default('#26AE61')->after('bottom_note_text_color');
        });
    }

    public function down(): void
    {
        Schema::table('home_sales_sections', function (Blueprint $table) {
            $table->dropColumn([
                'bottom_note_prefix',
                'bottom_note_highlight',
                'bottom_note_suffix',
                'bottom_note_text_color',
                'bottom_note_highlight_color',
            ]);
        });
    }
};
