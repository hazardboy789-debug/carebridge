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
        Schema::create('doctor_details', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->date('dob')->nullable();
    $table->string('gender')->nullable();
    $table->string('address')->nullable();
    $table->string('specialization')->nullable();
    $table->string('license_number')->nullable();
    $table->integer('experience_years')->nullable();
    $table->string('description')->nullable();
    $table->string('status')->default('pending');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_details');
    }
};
