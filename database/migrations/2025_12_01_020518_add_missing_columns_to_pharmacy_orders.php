<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Add pharmacy_id to pharmacy_orders if it doesn't exist
        if (Schema::hasTable('pharmacy_orders') && !Schema::hasColumn('pharmacy_orders', 'pharmacy_id')) {
            Schema::table('pharmacy_orders', function (Blueprint $table) {
                // CHANGE THIS LINE - remove constrained() temporarily
                $table->unsignedBigInteger('pharmacy_id')->nullable()->after('user_id');
                
                // Set default value to 1 (the default pharmacy we'll create)
                // This will be updated later when we add the foreign key
            });
        }

        // Add delivery_type to pharmacy_orders if it doesn't exist
        if (Schema::hasTable('pharmacy_orders') && !Schema::hasColumn('pharmacy_orders', 'delivery_type')) {
            Schema::table('pharmacy_orders', function (Blueprint $table) {
                $table->enum('delivery_type', ['pickup', 'delivery'])->default('pickup')->after('status');
            });
        }

        // Add patient_notes to pharmacy_orders if it doesn't exist
        if (Schema::hasTable('pharmacy_orders') && !Schema::hasColumn('pharmacy_orders', 'patient_notes')) {
            Schema::table('pharmacy_orders', function (Blueprint $table) {
                $table->text('patient_notes')->nullable()->after('shipping_address');
            });
        }

        // Set default pharmacy_id for existing records
        if (Schema::hasTable('pharmacy_orders') && Schema::hasColumn('pharmacy_orders', 'pharmacy_id')) {
            DB::table('pharmacy_orders')->whereNull('pharmacy_id')->update(['pharmacy_id' => 1]);
        }
    }

    public function down()
    {
        // Safe rollback - don't drop columns
    }
};