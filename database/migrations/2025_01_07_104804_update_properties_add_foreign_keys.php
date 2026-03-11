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
            // Change the propertyCategory and childType columns to unsignedBigInteger
            
            $table->unsignedBigInteger('propertyCategory')->nullable()->change();
            $table->unsignedBigInteger('childType')->nullable()->change();

            // Add foreign key constraints
            $table->foreign('propertyCategory')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('childType')->references('id')->on('child_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['propertyCategory']);
            $table->dropForeign(['childType']);

            // Optionally revert column types if necessary
            $table->integer('propertyCategory')->change();
            $table->integer('childType')->change();
        });
    }
};
