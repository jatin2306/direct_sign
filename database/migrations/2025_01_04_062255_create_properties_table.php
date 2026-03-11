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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('propertyType'); // e.g., sell or rent
            $table->integer('propertyCategory'); // e.g., residential, commercial
            $table->integer('childType'); // e.g., apartment, villa, office
            $table->string('propertyName'); 
            $table->text('address');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->integer('bedrooms')->nullable();
            $table->integer('bathrooms')->nullable();
            $table->integer('builtArea');
            $table->integer('plotArea')->nullable();
            $table->string('unitNo')->nullable();
            $table->string('floorNo')->nullable();
            $table->enum('furnished', ['yes', 'no', 'semi'])->default('no');;
            $table->boolean('balcony')->default(false);
            $table->boolean('community')->default(false);
            $table->string('view')->nullable();
            $table->integer('parking')->nullable();
            $table->string('status'); 
            $table->text('any_upgrades')->nullable();
            $table->json('amenities')->nullable();
            $table->string('communityFee')->nullable();
            $table->string('mortgaged')->nullable();
            $table->decimal('price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
