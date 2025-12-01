<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('license_number')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add a default pharmacy for existing orders
        DB::table('pharmacies')->insert([
            'name' => 'Main Pharmacy',
            'address' => '123 Main Street, City, State',
            'phone' => '+1234567890',
            'email' => 'pharmacy@carebridge.com',
            'license_number' => 'PHARM001',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('pharmacies');
    }
};