<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Add FK constraints now that pharmacy_orders and medicine_stock both exist
            $table->foreign('order_id')->references('id')->on('pharmacy_orders')->onDelete('cascade');
            $table->foreign('medicine_id')->references('id')->on('medicine_stock')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->dropForeign(['medicine_id']);
        });
    }
};
