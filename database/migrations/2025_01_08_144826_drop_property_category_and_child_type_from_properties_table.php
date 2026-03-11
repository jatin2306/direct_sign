<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Drop foreign key constraints first
            $table->dropForeign(['propertyCategory']);
            $table->dropForeign(['childType']);
            
            // Drop the columns
            $table->dropColumn(['propertyCategory', 'childType']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Re-add the columns
            $table->unsignedBigInteger('propertyCategory')->nullable();
            $table->unsignedBigInteger('childType')->nullable();

            // Re-add foreign key constraints
            $table->foreign('propertyCategory')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('childType')->references('id')->on('child_types')->onDelete('set null');
        });
    }
};
