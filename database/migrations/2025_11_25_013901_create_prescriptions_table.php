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
            $table->text('symptoms');
            $table->json('medicines');
            $table->text('instructions')->nullable();
            $table->text('notes')->nullable();
            $table->string('file_path')->nullable();
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            $table->index(['doctor_id', 'patient_id']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prescriptions');
    }
};