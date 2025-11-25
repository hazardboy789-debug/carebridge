<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // appointment, pharmacy, wallet_topup, etc.
            $table->string('reference_id')->nullable(); // appointment_id, order_id, etc.
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending'); // pending, completed, failed, refunded
            $table->string('payment_method')->nullable(); // card, cash, bank_transfer
            $table->string('transaction_id')->nullable(); // external payment gateway ID
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // additional data
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['type', 'status']);
            $table->index('transaction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};