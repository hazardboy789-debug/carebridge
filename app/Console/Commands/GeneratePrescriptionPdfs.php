<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Prescription;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class GeneratePrescriptionPdfs extends Command
{
    protected $signature = 'prescriptions:generate-pdfs {--dry-run}';
    protected $description = 'Generate PDF files for prescriptions missing files and backfill chat messages';

    public function handle(): int
    {
        $dry = $this->option('dry-run');
        $this->info('Scanning prescriptions for missing files...');

        $count = 0;
        Prescription::chunk(50, function($prescriptions) use (&$count, $dry) {
            foreach ($prescriptions as $prescription) {
                $needsPdf = !$prescription->file_path || !Storage::disk('public')->exists($prescription->file_path);
                if (! $needsPdf) {
                    continue;
                }

                $this->line('Prescription #' . $prescription->id . ' needs PDF');

                if ($dry) {
                    $this->line('  [dry-run] Would generate PDF and update record.');
                } else {
                    try {
                        $doctor = $prescription->doctor;
                        $patient = $prescription->patient;
                        $data = [
                            'prescription' => $prescription,
                            'doctor' => $doctor,
                            'patient' => $patient,
                            'medications' => $prescription->medicines_list,
                            'medicines' => $prescription->medicines_list,
                            'date' => now()->format('F d, Y'),
                            'prescriptionCode' => 'RX-' . strtoupper(bin2hex(random_bytes(4))),
                        ];

                        $pdf = Pdf::loadView('pdf.prescription', $data);
                        $fileName = 'prescriptions/prescription_' . $prescription->id . '_' . time() . '.pdf';
                        Storage::disk('public')->put($fileName, $pdf->output());

                        $prescription->update(['file_path' => $fileName]);

                        // Create chat message if missing
                        $exists = ChatMessage::where('metadata->prescription_id', $prescription->id)->exists();
                        if (! $exists) {
                            ChatMessage::create([
                                'sender_id' => $prescription->doctor_id,
                                'receiver_id' => $prescription->patient_id,
                                'message' => '📋 Prescription for ' . ($patient->name ?? 'patient'),
                                'message_type' => 'prescription',
                                'file_path' => $fileName,
                                'file_size' => Storage::disk('public')->size($fileName),
                                'metadata' => json_encode([
                                    'prescription_id' => $prescription->id,
                                    'diagnosis' => $prescription->diagnosis,
                                    'symptoms' => $prescription->symptoms,
                                    'follow_up_date' => $prescription->follow_up_date,
                                ]),
                            ]);
                        }

                        $this->line('  Generated PDF and created/updated chat message.');
                    } catch (\Exception $e) {
                        $this->error('  Error processing #' . $prescription->id . ': ' . $e->getMessage());
                    }
                }

                $count++;
            }
        });

        $this->info('Done. Processed: ' . $count . ' prescriptions.');

        return 0;
    }
}
