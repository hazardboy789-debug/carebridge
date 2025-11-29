<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 10, 2);
            $table->string('description');
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('reference_id')->nullable();
            $table->foreignId('appointment_id')->nullable()->constrained();
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['wallet_id', 'created_at']);
            $table->index('reference_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
};