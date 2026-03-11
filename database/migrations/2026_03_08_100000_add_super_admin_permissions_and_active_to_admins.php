<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (! Schema::hasColumn('admins', 'is_super_admin')) {
                $table->boolean('is_super_admin')->default(false);
            }
            if (! Schema::hasColumn('admins', 'permissions')) {
                $table->json('permissions')->nullable();
            }
            if (! Schema::hasColumn('admins', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });

        DB::table('admins')->update(['is_super_admin' => true, 'is_active' => true]);
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('admins', 'is_super_admin') ? 'is_super_admin' : null,
                Schema::hasColumn('admins', 'permissions') ? 'permissions' : null,
                Schema::hasColumn('admins', 'is_active') ? 'is_active' : null,
            ]);
            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
