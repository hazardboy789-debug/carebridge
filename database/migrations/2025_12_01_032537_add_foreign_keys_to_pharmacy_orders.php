<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pharmacy_orders', function (Blueprint $table) {
            // Add foreign key constraint after pharmacies table exists
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies');
        });
    }

    public function down()
    {
        Schema::table('pharmacy_orders', function (Blueprint $table) {
            $table->dropForeign(['pharmacy_id']);
        });
    }
};