<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prescription;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Storage;

class BackfillPrescriptionMessages extends Command
{
    protected $signature = 'prescriptions:backfill-chat {--dry-run}';
    protected $description = 'Backfill chat messages for existing prescriptions missing chat entries';

    public function handle()
    {
        $dry = $this->option('dry-run');
        $this->info('Scanning prescriptions...');

        $count = 0;
        Prescription::chunk(100, function($prescriptions) use (&$count, $dry) {
            foreach ($prescriptions as $prescription) {
                $exists = ChatMessage::whereRaw("JSON_EXTRACT(metadata, '$$.prescription_id') = ?", [$prescription->id])->exists();
                if ($exists) {
                    continue;
                }

                // create chat message entry
                $data = [
                    'sender_id' => $prescription->doctor_id,
                    'receiver_id' => $prescription->patient_id,
                    'message' => "📋 Prescription for " . ($prescription->patient->name ?? 'patient'),
                    'message_type' => 'prescription',
                    'file_path' => $prescription->file_path,
                    'file_size' => $prescription->file_path && Storage::disk('public')->exists($prescription->file_path) ? Storage::disk('public')->size($prescription->file_path) : null,
                    'metadata' => json_encode([
                        'prescription_id' => $prescription->id,
                        'diagnosis' => $prescription->diagnosis,
                        'symptoms' => $prescription->symptoms,
                        'follow_up_date' => $prescription->follow_up_date,
                    ]),
                ];

                if ($dry) {
                    $this->line('Would create ChatMessage for Prescription #' . $prescription->id);
                } else {
                    ChatMessage::create($data);
                    $this->line('Created ChatMessage for Prescription #' . $prescription->id);
                }

                $count++;
            }
        });

        $this->info("Done. Processed: $count prescriptions.");

        return 0;
    }
}
