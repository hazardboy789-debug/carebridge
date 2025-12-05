<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_details', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_details', 'consultation_fee')) {
                $table->decimal('consultation_fee', 8, 2)->default(0)->after('experience_years');
            }
        });
    }

    public function down(): void
    {
        Schema::table('doctor_details', function (Blueprint $table) {
            if (Schema::hasColumn('doctor_details', 'consultation_fee')) {
                $table->dropColumn('consultation_fee');
            }
        });
    }
};
