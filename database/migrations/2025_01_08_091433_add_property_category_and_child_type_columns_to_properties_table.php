<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            // Adding the new columns
            $table->unsignedBigInteger('property_category_id')->nullable();
            $table->unsignedBigInteger('child_type_id')->nullable();

            // Adding foreign key constraints
            $table->foreign('property_category_id')->references('id')->on('categories')->onDelete('set null');
            $table->foreign('child_type_id')->references('id')->on('child_types')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            // Dropping foreign key constraints
            $table->dropForeign(['property_category_id']);
            $table->dropForeign(['child_type_id']);
            
            // Dropping the columns
            $table->dropColumn(['property_category_id', 'child_type_id']);
        });
    }

};
