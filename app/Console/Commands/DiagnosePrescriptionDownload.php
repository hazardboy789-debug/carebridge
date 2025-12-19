<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DiagnosePrescriptionDownload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'diagnose:prescription';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose prescription chat message and prescription file paths and existence';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Listing all prescription ChatMessages...');
        $messages = \App\Models\ChatMessage::where('message_type', 'prescription')->get();
        if ($messages->isEmpty()) {
            $this->info('No prescription ChatMessage found');
        } else {
            foreach ($messages as $msg) {
                $path = storage_path('app/public/' . ($msg->file_path ?? ''));
                $this->line('---');
                $this->line('ChatMessage ID: ' . $msg->id);
                $this->line('  sender_id: ' . $msg->sender_id);
                $this->line('  receiver_id: ' . $msg->receiver_id);
                $this->line('  file_path: ' . ($msg->file_path ?? 'NULL'));
                $this->line('  storage path: ' . $path);
                $this->line('  file_exists: ' . (file_exists($path) ? 'yes' : 'no'));
                $this->line('  metadata: ' . json_encode($msg->metadata));
            }
        }

        $this->info('Checking latest Prescription...');
        $p = \App\Models\Prescription::latest()->first();
        if (! $p) {
            $this->info('No Prescription found');
        } else {
            $this->line('Prescription ID: ' . $p->id);
            $this->line('  file_path: ' . ($p->file_path ?? 'NULL'));
            $pPath = storage_path('app/public/' . ($p->file_path ?? ''));
            $this->line('  storage path: ' . $pPath);
            $this->line('  file_exists: ' . (file_exists($pPath) ? 'yes' : 'no'));
        }

        return 0;
    }
}
