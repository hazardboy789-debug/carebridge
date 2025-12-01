<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            if (!Schema::hasColumn('pharmacies', 'owner_name')) {
                $table->string('owner_name')->nullable()->after('name');
            }
            if (!Schema::hasColumn('pharmacies', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('address');
            }
            if (!Schema::hasColumn('pharmacies', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('pharmacies', 'opening_time')) {
                $table->time('opening_time')->nullable()->after('longitude');
            }
            if (!Schema::hasColumn('pharmacies', 'closing_time')) {
                $table->time('closing_time')->nullable()->after('opening_time');
            }
            if (!Schema::hasColumn('pharmacies', 'is_24_hours')) {
                $table->boolean('is_24_hours')->default(false)->after('closing_time');
            }
        });
    }

    public function down()
    {
        Schema::table('pharmacies', function (Blueprint $table) {
            $table->dropColumn(['owner_name', 'latitude', 'longitude', 'opening_time', 'closing_time', 'is_24_hours']);
        });
    }
};