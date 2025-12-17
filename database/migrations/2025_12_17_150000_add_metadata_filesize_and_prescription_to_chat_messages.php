<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            if (!Schema::hasColumn('chat_messages', 'file_size')) {
                $table->integer('file_size')->nullable()->after('file_path');
            }
            if (!Schema::hasColumn('chat_messages', 'metadata')) {
                $table->json('metadata')->nullable()->after('file_size');
            }
        });

        // If using MySQL, add 'prescription' to the enum values for message_type
        try {
            DB::statement("ALTER TABLE `chat_messages` MODIFY `message_type` ENUM('text','image','file','prescription') NOT NULL DEFAULT 'text'");
        } catch (\Exception $e) {
            // Some DB engines or setups may not support MODIFY in this way — ignore if it fails
            // We'll log to storage/logs if needed
            \Log::warning('Could not alter chat_messages.message_type enum: ' . $e->getMessage());
        }
    }

    public function down(): void
    {
        // Attempt to revert enum change (remove 'prescription')
        try {
            DB::statement("ALTER TABLE `chat_messages` MODIFY `message_type` ENUM('text','image','file') NOT NULL DEFAULT 'text'");
        } catch (\Exception $e) {
            \Log::warning('Could not revert chat_messages.message_type enum: ' . $e->getMessage());
        }

        Schema::table('chat_messages', function (Blueprint $table) {
            if (Schema::hasColumn('chat_messages', 'metadata')) {
                $table->dropColumn('metadata');
            }
            if (Schema::hasColumn('chat_messages', 'file_size')) {
                $table->dropColumn('file_size');
            }
        });
    }
};
