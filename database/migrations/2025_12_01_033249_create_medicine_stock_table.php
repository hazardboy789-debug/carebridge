<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('medicine_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained('pharmacies')->onDelete('cascade');
            $table->string('medicine_name');
            $table->text('description')->nullable();
            $table->string('manufacturer')->nullable();
            $table->decimal('price', 8, 2);
            $table->integer('quantity_available')->default(0);
            $table->integer('min_stock_level')->default(10);
            $table->string('category')->nullable();
            $table->string('prescription_required')->default('no'); // yes, no
            $table->text('side_effects')->nullable();
            $table->text('usage_instructions')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['pharmacy_id', 'is_active']);
            $table->index('category');
            $table->index('medicine_name');
        });

        // Add some sample medicine stock
        DB::table('medicine_stock')->insert([
            [
                'pharmacy_id' => 1,
                'medicine_name' => 'Paracetamol 500mg',
                'description' => 'Pain reliever and fever reducer',
                'manufacturer' => 'PharmaCorp',
                'price' => 5.99,
                'quantity_available' => 100,
                'min_stock_level' => 20,
                'category' => 'Pain Relief',
                'prescription_required' => 'no',
                'side_effects' => 'Rare: skin rash, nausea',
                'usage_instructions' => 'Take 1 tablet every 4-6 hours as needed',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pharmacy_id' => 1,
                'medicine_name' => 'Amoxicillin 250mg',
                'description' => 'Antibiotic for bacterial infections',
                'manufacturer' => 'MediLab',
                'price' => 15.50,
                'quantity_available' => 50,
                'min_stock_level' => 10,
                'category' => 'Antibiotics',
                'prescription_required' => 'yes',
                'side_effects' => 'Diarrhea, nausea, rash',
                'usage_instructions' => 'Take as directed by your doctor',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'pharmacy_id' => 1,
                'medicine_name' => 'Vitamin C 1000mg',
                'description' => 'Immune system support',
                'manufacturer' => 'HealthPlus',
                'price' => 12.99,
                'quantity_available' => 75,
                'min_stock_level' => 15,
                'category' => 'Vitamins',
                'prescription_required' => 'no',
                'side_effects' => 'Generally well tolerated',
                'usage_instructions' => 'Take 1 tablet daily with food',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('medicine_stock');
    }
};