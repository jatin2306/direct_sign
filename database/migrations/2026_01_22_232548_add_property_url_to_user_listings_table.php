<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPropertyUrlToUserListingsTable extends Migration
{
    public function up(): void
    {
        Schema::table('user_listings', function (Blueprint $table) {
            $table->string('property_url')->nullable()->after('property_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_listings', function (Blueprint $table) {
            $table->dropColumn('property_url');
        });
    }
}
