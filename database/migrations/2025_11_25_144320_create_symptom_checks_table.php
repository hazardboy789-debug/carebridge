<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('symptom_checks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('primary_symptom');
            $table->text('description');
            $table->json('additional_symptoms')->nullable();
            $table->enum('severity', ['very_mild', 'mild', 'moderate', 'severe', 'very_severe']);
            $table->string('recommended_specialty');
            $table->text('recommendation');
            $table->json('suggested_doctors')->nullable();
            $table->timestamps();
            // create_symptom_checks_table migration, add:
            $table->json('ai_analysis')->nullable();
            
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptom_checks');
    }
};