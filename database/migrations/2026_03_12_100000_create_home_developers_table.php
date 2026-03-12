<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('home_developers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo_text')->nullable();
            $table->boolean('logo_dark')->default(false);
            $table->string('search_slug')->nullable()->comment('Used to count properties e.g. Emaar, Azizi');
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('home_developers');
    }
};
