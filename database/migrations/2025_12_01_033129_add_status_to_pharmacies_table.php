<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            if (!Schema::hasColumn('pharmacies', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected', 'suspended'])
                      ->default('approved')
                      ->after('is_active');
            }
        });

        // Update existing pharmacies to have 'approved' status
        if (Schema::hasTable('pharmacies')) {
            DB::table('pharmacies')->update(['status' => 'approved']);
        }
    }

    public function down()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};