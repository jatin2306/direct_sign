<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRegulatoryInfoToPropertiesTable extends Migration
{
    public function up()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->string('reference')->nullable();
            $table->string('broker_license')->nullable();
            $table->string('zone_name')->nullable();
            $table->string('dld_permit_number')->nullable();
            $table->string('agent_license')->nullable();
            $table->string('regulatory_image')->nullable();
        });
    }

    public function down()
    {
        Schema::table('properties', function (Blueprint $table) {
            $table->dropColumn([
                'reference',
                'broker_license',
                'zone_name',
                'dld_permit_number',
                'agent_license',
                'regulatory_image',
            ]);
        });
    }
}

