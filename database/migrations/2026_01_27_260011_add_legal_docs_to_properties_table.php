<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->enum('listing_type', ['sell','rent'])->nullable()->after('id');
            $table->enum('rent_frequency', ['year','month','custom'])->nullable();
            $table->string('title_deed')->nullable();
            $table->string('oqood')->nullable();
            $table->string('emirates_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'listing_type',
                'rent_frequency',
                'title_deed',
                'oqood',
                'emirates_id'
            ]);
        });
    }
};
