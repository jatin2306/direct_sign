<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->enum('listing_type', ['sell', 'rent']);

            $table->string('title_deed')->nullable();
            $table->string('oqood')->nullable();
            $table->string('emirates_id');

            $table->enum('property_status', ['rented', 'vacant', 'vacant_on_transfer']);

            $table->enum('rent_frequency', ['year', 'month', 'custom'])->nullable();
            $table->integer('price');

            $table->json('images')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('property_id')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_listings');
    }
};
