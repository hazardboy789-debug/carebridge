<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class PrescriptionModal extends Component
{
    public $isOpen = false;
    public $patient;
    
    public $diagnosis = '';
    public $symptoms = '';
    public $medicines = [];
    public $instructions = '';
    public $notes = '';
    public $followUpDate = '';
    
    public $medicineName = '';
    public $medicineDosage = '';
    public $medicineFrequency = '';
    public $medicineDuration = '';

    protected $rules = [
        'diagnosis' => 'required|string|min:3',
        'symptoms' => 'required|string|min:3',
        'medicines' => 'required|array|min:1',
        'instructions' => 'nullable|string',
        'notes' => 'nullable|string',
        'followUpDate' => 'nullable|date|after:today',
    ];

    public function openModal($patientId)
    {
        $this->patient = User::find($patientId);
        $this->isOpen = true;
        $this->resetForm();
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->diagnosis = '';
        $this->symptoms = '';
        $this->medicines = [];
        $this->instructions = '';
        $this->notes = '';
        $this->followUpDate = '';
        $this->medicineName = '';
        $this->medicineDosage = '';
        $this->medicineFrequency = '';
        $this->medicineDuration = '';
    }

    public function addMedicine()
    {
        $this->validate([
            'medicineName' => 'required|string|min:2',
            'medicineDosage' => 'required|string|min:2',
            'medicineFrequency' => 'required|string|min:2',
            'medicineDuration' => 'required|string|min:2',
        ]);

        $this->medicines[] = [
            'name' => $this->medicineName,
            'dosage' => $this->medicineDosage,
            'frequency' => $this->medicineFrequency,
            'duration' => $this->medicineDuration,
        ];

        $this->medicineName = '';
        $this->medicineDosage = '';
        $this->medicineFrequency = '';
        $this->medicineDuration = '';

        session()->flash('medicine_added', 'Medicine added successfully!');
    }

    public function removeMedicine($index)
    {
        unset($this->medicines[$index]);
        $this->medicines = array_values($this->medicines);
    }

    public function generatePrescription()
    {
        $this->validate();

        try {
            $prescription = Prescription::create([
                'doctor_id' => auth()->id(),
                'patient_id' => $this->patient->id,
                'diagnosis' => $this->diagnosis,
                'symptoms' => $this->symptoms,
                'medicines' => $this->medicines,
                'instructions' => $this->instructions,
                'notes' => $this->notes,
                'follow_up_date' => $this->followUpDate,
            ]);

            $htmlContent = $this->generatePrescriptionHTML($prescription);
            
            $fileName = 'prescriptions/prescription_' . $prescription->id . '_' . time() . '.html';
            Storage::disk('public')->put($fileName, $htmlContent);
            
            $prescription->update(['file_path' => $fileName]);

            $this->dispatch('prescriptionCreated');
            $this->dispatch('messageSent');

            $this->closeModal();
            session()->flash('success', 'Prescription created successfully! Patient can download it from their chat.');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create prescription: ' . $e->getMessage());
        }
    }

    private function generatePrescriptionHTML($prescription)
    {
        $doctor = auth()->user();
        $patient = $this->patient;

        return "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>Medical Prescription</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; margin: 40px; }
                .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 30px; }
                .section { margin-bottom: 20px; }
                .section-title { background: #f8f9fa; padding: 8px; font-weight: bold; border-left: 4px solid #007bff; }
                .medicine-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
                .medicine-table th, .medicine-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                .medicine-table th { background-color: #f8f9fa; }
                .footer { margin-top: 50px; border-top: 1px solid #333; padding-top: 20px; }
                .signature { float: right; text-align: center; }
                @media print {
                    body { margin: 0; }
                    .no-print { display: none; }
                }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>MEDICAL PRESCRIPTION</h1>
                <p><strong>CareBridge Medical Center</strong></p>
                <p>123 Health Street, Medical City | Phone: (555) 123-4567</p>
            </div>

            <div class='section'>
                <div style='float: left; width: 50%;'>
                    <p><strong>Patient:</strong> {$patient->name}</p>
                    <p><strong>Date:</strong> " . now()->format('F d, Y') . "</p>
                </div>
                <div style='float: right; width: 50%; text-align: right;'>
                    <p><strong>Doctor:</strong> Dr. {$doctor->name}</p>
                    <p><strong>License No:</strong> MED" . rand(100000, 999999) . "</p>
                </div>
                <div style='clear: both;'></div>
            </div>

            <div class='section'>
                <div class='section-title'>DIAGNOSIS</div>
                <p>{$prescription->diagnosis}</p>
            </div>

            <div class='section'>
                <div class='section-title'>SYMPTOMS</div>
                <p>{$prescription->symptoms}</p>
            </div>

            <div class='section'>
                <div class='section-title'>PRESCRIBED MEDICATIONS</div>
                <table class='medicine-table'>
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        " . $this->generateMedicineRows($prescription->medicines) . "
                    </tbody>
                </table>
            </div>

            " . ($prescription->instructions ? "
            <div class='section'>
                <div class='section-title'>SPECIAL INSTRUCTIONS</div>
                <p>{$prescription->instructions}</p>
            </div>
            " : "") . "

            " . ($prescription->notes ? "
            <div class='section'>
                <div class='section-title'>ADDITIONAL NOTES</div>
                <p>{$prescription->notes}</p>
            </div>
            " : "") . "

            " . ($prescription->follow_up_date ? "
            <div class='section'>
                <div class='section-title'>FOLLOW-UP</div>
                <p>Follow-up appointment on: " . \Carbon\Carbon::parse($prescription->follow_up_date)->format('F d, Y') . "</p>
            </div>
            " : "") . "

            <div class='footer'>
                <div class='signature'>
                    <p>_________________________</p>
                    <p><strong>Dr. {$doctor->name}</strong></p>
                    <p>Medical Practitioner</p>
                </div>
                <div style='clear: both;'></div>
            </div>

            <div class='no-print' style='margin-top: 30px; text-align: center;'>
                <button onclick='window.print()' style='background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;'>
                    Print Prescription
                </button>
            </div>
        </body>
        </html>
        ";
    }

    private function generateMedicineRows($medicines)
    {
        $rows = '';
        foreach ($medicines as $medicine) {
            $rows .= "
            <tr>
                <td>{$medicine['name']}</td>
                <td>{$medicine['dosage']}</td>
                <td>{$medicine['frequency']}</td>
                <td>{$medicine['duration']}</td>
            </tr>
            ";
        }
        return $rows;
    }

    public function render()
    {
        return view('livewire.doctor.prescription-modal');
    }
}