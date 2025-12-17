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
    
    // Form fields
    public $diagnosis = '';
    public $medications = [''];
    public $instructions = '';
    public $followUpDate = '';
    public $notes = '';
    public $signatureFile;
    public $labTests = [''];

    protected $rules = [
        'diagnosis' => 'required|string|max:500',
        'medications.*' => 'required|string|max:255',
        'instructions' => 'required|string|max:1000',
        'followUpDate' => 'nullable|date|after:today',
        'notes' => 'nullable|string|max:1000',
        'signatureFile' => 'nullable|image|max:2048',
        'labTests.*' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'medications.*.required' => 'Each medication field is required',
        'medications.*.max' => 'Medication name is too long',
    ];

    protected $listeners = ['openPrescriptionModal'];

    public function mount()
    {
        // Initialize with one empty medication and lab test
        $this->medications = [''];
        $this->labTests = [''];
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
        $this->medications = [''];
        $this->labTests = [''];
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function addMedication()
    {
        $this->medications[] = '';
    }

    public function removeMedication($index)
    {
        if (count($this->medications) > 1) {
            unset($this->medications[$index]);
            $this->medications = array_values($this->medications);
        }
    }

    public function addLabTest()
    {
        $this->labTests[] = '';
    }

    public function removeLabTest($index)
    {
        if (count($this->labTests) > 1) {
            unset($this->labTests[$index]);
            $this->labTests = array_values($this->labTests);
        }
    }

    public function generatePrescription()
    {
        try {
            // Validate form
            $validated = $this->validate();
            
            // Process signature file if uploaded
            $signaturePath = null;
            if ($this->signatureFile) {
                $signaturePath = $this->signatureFile->store('prescriptions/signatures', 'public');
            }

            // Filter out empty medications and lab tests
            $medications = array_filter($validated['medications']);
            $labTests = array_filter($validated['labTests']);

            // Create prescription record
            $prescription = Prescription::create([
                'doctor_id' => auth()->id(),
                'patient_id' => $this->patientId,
                'diagnosis' => $validated['diagnosis'],
                'medications' => json_encode($medications),
                'instructions' => $validated['instructions'],
                'follow_up_date' => $validated['followUpDate'] ?: null,
                'notes' => $validated['notes'] ?: null,
                'lab_tests' => json_encode($labTests),
                'signature_path' => $signaturePath,
                'prescription_date' => now(),
                'status' => 'active',
            ]);

            Log::info('Prescription created: ' . $prescription->id);

            // Generate PDF
            $this->generatePDF($prescription);

            // Send as message in chat
            $this->sendPrescriptionAsMessage($prescription);

            // Close modal and reset
            $this->closeModal();

            // Emit event to parent component
            $this->dispatch('prescription-created', prescriptionId: $prescription->id);

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
                'medications' => json_decode($prescription->medications, true),
                'labTests' => json_decode($prescription->lab_tests, true),
                'date' => now()->format('F d, Y'),
                'prescriptionCode' => 'RX-' . strtoupper(Str::random(8)),
            ];

            $pdf = Pdf::loadView('pdf.prescription', $data);
            
            // Save PDF to storage
            $fileName = 'prescriptions/prescription_' . $prescription->id . '_' . time() . '.pdf';
            Storage::disk('public')->put($fileName, $pdf->output());
            
            // Update prescription with PDF path
            $prescription->update(['pdf_path' => $fileName]);
            
            Log::info('PDF generated for prescription: ' . $prescription->id);
            
            return $pdf;
        } catch (\Exception $e) {
            Log::error('Error generating PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    private function sendPrescriptionAsMessage($prescription)
    {
        try {
            $doctor = auth()->user();
            
            // Create a message record for the prescription
            $chatMessage = new \App\Models\ChatMessage();
            $chatMessage->sender_id = $doctor->id;
            $chatMessage->receiver_id = $this->patientId;
            $chatMessage->message = "📋 Prescription for " . $this->patient->name;
            $chatMessage->message_type = 'prescription';
            $chatMessage->file_path = $prescription->pdf_path;
            $chatMessage->file_size = Storage::disk('public')->size($prescription->pdf_path);
            $chatMessage->metadata = json_encode([
                'prescription_id' => $prescription->id,
                'diagnosis' => $prescription->diagnosis,
                'follow_up_date' => $prescription->follow_up_date,
            ]);
            $chatMessage->save();

            Log::info('Prescription sent as chat message: ' . $chatMessage->id);

            // Update prescription status
            $prescription->update(['status' => 'sent']);

        } catch (\Exception $e) {
            Log::error('Error sending prescription as message: ' . $e->getMessage());
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.doctor.prescription-modal');
    }
}