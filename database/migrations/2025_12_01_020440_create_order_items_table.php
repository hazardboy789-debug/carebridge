<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('pharmacy_orders')->onDelete('cascade');
                $table->foreignId('medicine_id')->constrained('medicine_stock')->onDelete('cascade');
                $table->integer('quantity');
                $table->decimal('unit_price', 8, 2);
                $table->decimal('total_price', 8, 2);
                $table->text('instructions')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};