<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Prescription;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    /**
     * Download prescription by chat message ID
     */
    public function downloadByMessage($messageId)
    {
        try {
            $message = ChatMessage::findOrFail($messageId);
            
            // Check if user has permission to download
            if (!in_array(auth()->id(), [$message->sender_id, $message->receiver_id])) {
                abort(403, 'You do not have permission to download this prescription.');
            }
            
            if (!$message->file_path || !Storage::disk('public')->exists($message->file_path)) {
                abort(404, 'Prescription file not found.');
            }
            
            // Mark message as read if receiver is downloading
            if ($message->receiver_id === auth()->id() && !$message->read_at) {
                $message->update(['read_at' => now()]);
            }
            
            $path = storage_path('app/public/' . $message->file_path);
            $filename = 'prescription_' . $message->id . '_' . date('Y-m-d') . '.pdf';
            
            return response()->download($path, $filename);
            
        } catch (\Exception $e) {
            Log::error('Error downloading prescription by message: ' . $e->getMessage());
            abort(500, 'Failed to download prescription.');
        }
    }

    /**
     * Download prescription by prescription ID
     */
    public function download($prescriptionId)
    {
        try {
            $prescription = Prescription::findOrFail($prescriptionId);
            
            // Check if user has permission (doctor who created or patient who received)
            if (auth()->id() !== $prescription->doctor_id && auth()->id() !== $prescription->patient_id) {
                abort(403, 'You do not have permission to download this prescription.');
            }
            
            if (!$prescription->file_path || !Storage::disk('public')->exists($prescription->file_path)) {
                abort(404, 'Prescription PDF not found.');
            }
            
            $path = storage_path('app/public/' . $prescription->file_path);
            $filename = 'prescription_' . $prescription->id . '_' . date('Y-m-d') . '.pdf';
            
            return response()->download($path, $filename);
            
        } catch (\Exception $e) {
            Log::error('Error downloading prescription: ' . $e->getMessage());
            abort(500, 'Failed to download prescription.');
        }
    }
}
