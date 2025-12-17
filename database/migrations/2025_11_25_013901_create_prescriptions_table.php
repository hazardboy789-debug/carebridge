<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->text('diagnosis');
            $table->json('medications'); // Store as JSON array
            $table->text('instructions');
            $table->date('follow_up_date')->nullable();
            $table->text('notes')->nullable();
            $table->json('lab_tests')->nullable();
            $table->string('signature_path')->nullable();
            $table->string('pdf_path')->nullable();
            $table->date('prescription_date');
            $table->enum('status', ['active', 'expired', 'cancelled'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};