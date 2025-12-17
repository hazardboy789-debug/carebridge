<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\User;
use App\Models\Prescription;
use Livewire\WithFileUploads;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.doctor')]
class PrescriptionModal extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $patientId;
    public $patient;
    
    // Form fields - UPDATED to match your database
    public $diagnosis = '';
    public $symptoms = ''; // Added symptoms field
    public $medicines = ['']; // Changed from medications to medicines
    public $instructions = '';
    public $followUpDate = '';
    public $notes = '';
    public $fileUpload; // Changed from signatureFile to fileUpload

    protected $rules = [
        'diagnosis' => 'required|string|max:500',
        'symptoms' => 'required|string|max:500', // Added symptoms validation
        'medicines.*' => 'required|string|max:500', // Changed from medications
        'instructions' => 'required|string|max:1000',
        'followUpDate' => 'nullable|date|after:today',
        'notes' => 'nullable|string|max:1000',
        'fileUpload' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048', // Changed from signatureFile
    ];

    protected $messages = [
        'medicines.*.required' => 'Each medicine field is required',
        'medicines.*.max' => 'Medicine name is too long',
        'symptoms.required' => 'Please describe the symptoms',
    ];

    protected $listeners = ['openPrescriptionModal'];

    public function mount()
    {
        // Initialize with one empty medicine
        $this->medicines = [''];
    }

    public function openPrescriptionModal($patientId)
    {
        try {
            $this->patientId = $patientId;
            $this->patient = User::findOrFail($patientId);
            $this->showModal = true;
            
            Log::info('Prescription modal opened for patient: ' . $patientId);
        } catch (\Exception $e) {
            Log::error('Error opening prescription modal: ' . $e->getMessage());
            session()->flash('error', 'Patient not found.');
        }
    }

    public function closeModal()
    {
        $this->reset();
        $this->medicines = [''];
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function addMedicine() // Changed from addMedication
    {
        $this->medicines[] = '';
    }

    public function removeMedicine($index) // Changed from removeMedication
    {
        if (count($this->medicines) > 1) {
            unset($this->medicines[$index]);
            $this->medicines = array_values($this->medicines);
        }
    }

    public function generatePrescription()
    {
        try {
            // Validate form
            $validated = $this->validate();
            
            // Process file upload if exists
            $filePath = null;
            if ($this->fileUpload) {
                $filePath = $this->fileUpload->store('prescriptions/files', 'public');
            }

            // Filter out empty medicines
            $medicines = array_filter($validated['medicines']);

            // Create prescription record matching your database schema
            $prescription = Prescription::create([
                'doctor_id' => auth()->id(),
                'patient_id' => $this->patientId,
                'diagnosis' => $validated['diagnosis'],
                'symptoms' => $validated['symptoms'], // Added symptoms
                'medicines' => json_encode($medicines), // Changed to 'medicines'
                'instructions' => $validated['instructions'],
                'follow_up_date' => $validated['followUpDate'] ?: null,
                'notes' => $validated['notes'] ?: null,
                'file_path' => $filePath, // Changed to 'file_path'
            ]);

            Log::info('Prescription created: ' . $prescription->id);

            // Generate PDF - Optional, since you have file_path for uploaded files
            if (!$filePath || pathinfo($filePath, PATHINFO_EXTENSION) !== 'pdf') {
                // Generate PDF if no file was uploaded or file is not PDF
                $this->generatePDF($prescription);
            }

            // Send as message in chat
            $this->sendPrescriptionAsMessage($prescription, $filePath);

            // Close modal and reset
            $this->closeModal();

            // Emit event so other components (e.g., doctor chat) can react
            $this->emit('prescriptionCreated', $prescription->id);

            // Show success message
            session()->flash('success', 'Prescription created and sent successfully!');

        } catch (\Exception $e) {
            Log::error('Error generating prescription: ' . $e->getMessage());
            session()->flash('error', 'Failed to create prescription: ' . $e->getMessage());
        }
    }

    private function generatePDF($prescription)
    {
        try {
            $doctor = auth()->user();
            
            $data = [
                'prescription' => $prescription,
                'doctor' => $doctor,
                'patient' => $this->patient,
                'medicines' => json_decode($prescription->medicines, true),
                'date' => now()->format('F d, Y'),
                'prescriptionCode' => 'RX-' . strtoupper(Str::random(8)),
            ];

            $pdf = Pdf::loadView('pdf.prescription', $data);
            
            // Save PDF to storage
            $fileName = 'prescriptions/prescription_' . $prescription->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());
            
            // Update prescription with PDF path
            $prescription->update(['file_path' => $fileName]);
            
            Log::info('PDF generated for prescription: ' . $prescription->id);
            
            return $pdf;
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            // Don't throw error, just log it
            return null;
        }
    }

    private function sendPrescriptionAsMessage($prescription, $filePath = null)
    {
        try {
            $doctor = auth()->user();
            
            // Determine message type based on file
            $messageType = 'file';
            if ($filePath) {
                $extension = pathinfo($filePath, PATHINFO_EXTENSION);
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $messageType = 'image';
                } elseif ($extension === 'pdf') {
                    $messageType = 'prescription';
                }
            } else {
                $messageType = 'prescription';
            }
            
            // Create a message record for the prescription
            $chatMessage = new \App\Models\ChatMessage();
            $chatMessage->sender_id = $doctor->id;
            $chatMessage->receiver_id = $this->patientId;
            $chatMessage->message = "📋 Prescription for " . $this->patient->name;
            $chatMessage->message_type = $messageType;
            $chatMessage->file_path = $prescription->file_path;
            
            // If we have a file, get its size
            if ($prescription->file_path && Storage::disk('public')->exists($prescription->file_path)) {
                $chatMessage->file_size = Storage::disk('public')->size($prescription->file_path);
            }
            
            $chatMessage->metadata = json_encode([
                'prescription_id' => $prescription->id,
                'diagnosis' => $prescription->diagnosis,
                'symptoms' => $prescription->symptoms,
                'follow_up_date' => $prescription->follow_up_date,
            ]);
            $chatMessage->save();

            Log::info('Prescription sent as chat message: ' . $chatMessage->id);

        } catch (\Exception $e) {
            Log::error('Error sending prescription as message: ' . $e->getMessage());
            // Don't throw error, just log it
        }
    }

    public function render()
    {
        return view('livewire.doctor.prescription-modal');
    }
}