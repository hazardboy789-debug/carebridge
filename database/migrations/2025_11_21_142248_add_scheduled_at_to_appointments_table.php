<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // Check if scheduled_at column doesn't exist before adding it
            if (!Schema::hasColumn('appointments', 'scheduled_at')) {
                $table->dateTime('scheduled_at')->nullable()->after('doctor_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('scheduled_at');
        });
    }
};