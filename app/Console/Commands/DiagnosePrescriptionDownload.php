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
        $this->info('Checking latest prescription ChatMessage...');

        $m = \App\Models\ChatMessage::where('message_type', 'prescription')->latest()->first();
        if (! $m) {
            $this->info('No prescription ChatMessage found');
        } else {
            $this->line('ChatMessage ID: ' . $m->id);
            $this->line('  file_path: ' . ($m->file_path ?? 'NULL'));
            $path = storage_path('app/public/' . ($m->file_path ?? ''));
            $this->line('  storage path: ' . $path);
            $this->line('  file_exists: ' . (file_exists($path) ? 'yes' : 'no'));
            $this->line('  metadata: ' . json_encode($m->metadata));
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
