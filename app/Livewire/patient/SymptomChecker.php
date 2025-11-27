<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\SymptomCheck;
use App\Models\User;
use App\Models\DoctorDetail;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient')]
class SymptomChecker extends Component
{
    public $primarySymptom = '';
    public $description = '';
    public $additionalSymptoms = [];
    public $severity = 'moderate';
    
    // Results
    public $showResults = false;
    public $recommendedSpecialty = '';
    public $recommendation = '';
    public $suggestedDoctors = [];
    public $suggestedDoctor = null; // ADDED THIS
    public $checkHistory = [];
    public $aiAnalysis = null;
    public $isAnalyzing = false;

    // Available symptoms and severities
    public $availableSymptoms = [
        'Fever', 'Headache', 'Cough', 'Fatigue', 'Nausea', 
        'Dizziness', 'Pain', 'Rash', 'Swelling', 'Shortness of breath',
        'Chest pain', 'Abdominal pain', 'Joint pain', 'Vision problems',
        'Hearing loss', 'Skin irritation', 'Muscle weakness', 'Anxiety',
        'Depression', 'Stress', 'Back pain', 'Stomach pain', 'Palpitations'
    ];

    public $severityLevels = [
        'very_mild' => 'Very Mild',
        'mild' => 'Mild', 
        'moderate' => 'Moderate',
        'severe' => 'Severe',
        'very_severe' => 'Very Severe'
    ];

    // Map AI specialties to your database specializations
    protected $specialtyMapping = [
        'general_practitioner' => ['General Physician', 'Family Medicine', 'Internal Medicine', 'General Practice'],
        'cardiologist' => ['Cardiology', 'Cardiovascular', 'Heart Specialist'],
        'psychiatrist' => ['Psychiatry', 'Mental Health', 'Psychology'],
        'orthopedic' => ['Orthopedics', 'Orthopedic Surgery', 'Bone Specialist'],
        'ophthalmologist' => ['Ophthalmology', 'Eye Specialist'],
        'dermatologist' => ['Dermatology', 'Skin Specialist'],
        'gastroenterologist' => ['Gastroenterology', 'Stomach Specialist'],
        'ent_specialist' => ['ENT', 'Otolaryngology', 'Ear Nose Throat'],
        'neurologist' => ['Neurology', 'Brain Specialist'],
        'pediatrician' => ['Pediatrics', 'Child Specialist'],
    ];

    protected $specialtyNames = [
        'general_practitioner' => 'General Physician',
        'cardiologist' => 'Cardiologist',
        'psychiatrist' => 'Psychiatrist',
        'orthopedic' => 'Orthopedic Specialist',
        'ophthalmologist' => 'Ophthalmologist',
        'dermatologist' => 'Dermatologist',
        'gastroenterologist' => 'Gastroenterologist',
        'ent_specialist' => 'ENT Specialist',
        'neurologist' => 'Neurologist',
        'pediatrician' => 'Pediatrician',
    ];

    // ADDED: Event listener for booking
    protected $listeners = ['bookWithDoctor' => 'handleBookWithDoctor'];

    public function mount()
    {
        $this->loadCheckHistory();
    }

    public function loadCheckHistory()
    {
        $this->checkHistory = SymptomCheck::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    public function analyzeSymptoms()
    {
        $this->validate([
            'primarySymptom' => 'required|string|min:2',
            'description' => 'required|string|min:10',
            'severity' => 'required|in:very_mild,mild,moderate,severe,very_severe',
        ]);

        $this->isAnalyzing = true;

        try {
            // Try AI analysis first
            $aiResult = $this->analyzeWithAI();
            
            if ($aiResult && isset($aiResult['specialty'])) {
                // Use AI results
                $this->recommendedSpecialty = $aiResult['specialty'];
                $this->recommendation = $aiResult['recommendation'];
                $this->aiAnalysis = $aiResult;
            } else {
                // Fallback to rule-based system
                $this->recommendedSpecialty = $this->determineSpecialty();
                $this->recommendation = $this->generateRecommendation();
                $this->aiAnalysis = null;
            }

            // Load REAL doctors from database
            $this->suggestedDoctors = $this->findRealDoctors();

            // Save to history
            $symptomCheck = SymptomCheck::create([
                'user_id' => auth()->id(),
                'primary_symptom' => $this->primarySymptom,
                'description' => $this->description,
                'additional_symptoms' => $this->additionalSymptoms,
                'severity' => $this->severity,
                'recommended_specialty' => $this->recommendedSpecialty,
                'recommendation' => $this->recommendation,
                'suggested_doctors' => $this->suggestedDoctors,
                'ai_analysis' => $this->aiAnalysis,
            ]);

            $this->showResults = true;
            $this->loadCheckHistory();

            session()->flash('success', 'Symptoms analyzed successfully using AI!');

        } catch (\Exception $e) {
            Log::error('Symptom analysis error: ' . $e->getMessage());
            session()->flash('error', 'Failed to analyze symptoms. Please try again.');
        } finally {
            $this->isAnalyzing = false;
        }
    }

    private function analyzeWithAI()
    {
        try {
            $symptomDescription = "
            PRIMARY SYMPTOM: {$this->primarySymptom}
            ADDITIONAL SYMPTOMS: " . implode(', ', $this->additionalSymptoms) . "
            SEVERITY LEVEL: {$this->severityLevels[$this->severity]}
            DETAILED DESCRIPTION: {$this->description}
            ";

            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a medical triage assistant. Analyze the symptoms and return a JSON response with this exact structure:
                        {
                            \"specialty\": \"medical_specialty\",
                            \"urgency\": \"low/medium/high/emergency\",
                            \"recommendation\": \"detailed medical advice and next steps\",
                            \"possible_conditions\": [\"list of possible conditions\"],
                            \"warning_signs\": [\"list of red flag symptoms to watch for\"],
                            \"immediate_actions\": [\"list of immediate steps patient should take\"]
                        }
                        
                        Available specialties: general_practitioner, cardiologist, psychiatrist, orthopedic, ophthalmologist, dermatologist, gastroenterologist, ent_specialist, neurologist, pediatrician
                        
                        Be medically conservative. Always emphasize consulting healthcare professionals. For emergencies, clearly state to seek immediate medical attention."
                    ],
                    [
                        'role' => 'user',
                        'content' => "Please analyze these symptoms and provide medical guidance:\n{$symptomDescription}"
                    ]
                ],
                'max_tokens' => 1000,
                'temperature' => 0.3,
                'response_format' => ['type' => 'json_object']
            ]);

            $content = $response->choices[0]->message->content;
            Log::info('OpenAI Response: ' . $content);
            
            return json_decode($content, true);

        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return null;
        }
    }

    private function determineSpecialty()
    {
        $primarySymptomLower = strtolower($this->primarySymptom);
        
        $symptomSpecialtyMap = [
            'fever' => 'general_practitioner',
            'headache' => 'general_practitioner',
            'cough' => 'general_practitioner',
            'fatigue' => 'general_practitioner',
            'nausea' => 'general_practitioner',
            'chest pain' => 'cardiologist',
            'shortness of breath' => 'cardiologist',
            'palpitations' => 'cardiologist',
            'anxiety' => 'psychiatrist',
            'depression' => 'psychiatrist',
            'stress' => 'psychiatrist',
            'joint pain' => 'orthopedic',
            'back pain' => 'orthopedic',
            'muscle weakness' => 'orthopedic',
            'vision problems' => 'ophthalmologist',
            'eye pain' => 'ophthalmologist',
            'rash' => 'dermatologist',
            'skin irritation' => 'dermatologist',
            'abdominal pain' => 'gastroenterologist',
            'stomach pain' => 'gastroenterologist',
            'hearing loss' => 'ent_specialist',
            'ear pain' => 'ent_specialist',
        ];

        foreach ($symptomSpecialtyMap as $symptom => $specialty) {
            if (str_contains($primarySymptomLower, $symptom)) {
                return $specialty;
            }
        }

        foreach ($this->additionalSymptoms as $symptom) {
            $symptomLower = strtolower($symptom);
            foreach ($symptomSpecialtyMap as $symptomKey => $specialty) {
                if (str_contains($symptomLower, $symptomKey)) {
                    return $specialty;
                }
            }
        }

        return 'general_practitioner';
    }

    private function generateRecommendation()
    {
        $severity = $this->severity;
        $specialty = $this->recommendedSpecialty;
        
        $recommendations = [
            'very_mild' => "Your symptoms appear to be very mild. Consider self-care measures and monitor your condition.",
            'mild' => "Your symptoms are mild. Schedule a non-urgent appointment with a {$this->specialtyNames[$specialty]}.",
            'moderate' => "Your symptoms are moderate. Schedule an appointment with a {$this->specialtyNames[$specialty]} soon.",
            'severe' => "Your symptoms are severe. Contact a {$this->specialtyNames[$specialty]} as soon as possible.",
            'very_severe' => "Your symptoms appear to be very severe. Seek immediate medical attention.",
        ];

        return $recommendations[$severity] ?? $recommendations['moderate'];
    }

    private function findRealDoctors()
    {
        // Query by specialization code (e.g., 'general_practitioner')
        $doctorDetails = DoctorDetail::where('specialization', $this->recommendedSpecialty)
            ->where('status', 'approved')
            ->with('user')
            ->limit(4)
            ->get();

        // Set the first doctor as the suggested doctor
        if ($doctorDetails->count() > 0) {
            $firstDoctor = $doctorDetails->first();
            $this->suggestedDoctor = $firstDoctor->user; // This sets the suggested doctor
        }

        // Map all doctors for the list
        $doctors = $doctorDetails->map(function ($doctorDetail) {
            return [
                'id' => $doctorDetail->user_id,
                'name' => 'Dr. ' . $doctorDetail->user->name,
                'specialty' => $this->specialtyNames[$doctorDetail->specialization] ?? $doctorDetail->specialization,
                'experience' => $doctorDetail->experience_years ? $doctorDetail->experience_years . ' years experience' : 'Experienced',
                'license' => $doctorDetail->license_number ? 'License: ' . $doctorDetail->license_number : 'Licensed',
                'description' => $doctorDetail->description ?? 'Professional medical practitioner',
            ];
        })->toArray();

        // If no doctors found, fallback to general practitioners
        if (empty($doctors)) {
            $doctorDetails = DoctorDetail::where('status', 'approved')
                ->where('specialization', 'general_practitioner')
                ->with('user')
                ->limit(4)
                ->get();

            // Set the first doctor as the suggested doctor
            if ($doctorDetails->count() > 0) {
                $firstDoctor = $doctorDetails->first();
                $this->suggestedDoctor = $firstDoctor->user; // This sets the suggested doctor
            }

            $doctors = $doctorDetails->map(function ($doctorDetail) {
                return [
                    'id' => $doctorDetail->user_id,
                    'name' => 'Dr. ' . $doctorDetail->user->name,
                    'specialty' => $this->specialtyNames[$doctorDetail->specialization] ?? $doctorDetail->specialization,
                    'experience' => $doctorDetail->experience_years ? $doctorDetail->experience_years . ' years experience' : 'Experienced',
                    'license' => $doctorDetail->license_number ? 'License: ' . $doctorDetail->license_number : 'Licensed',
                    'description' => $doctorDetail->description ?? 'Professional medical practitioner',
                ];
            })->toArray();
        }

        return $doctors;
    }

    // ADDED: Handle booking from the blade file
    public function handleBookWithDoctor($doctorId, $symptoms = null)
    {
        // Store in session for the appointments page
        session([
            'recommended_doctor_id' => $doctorId,
            'symptoms_description' => $symptoms ?? $this->description,
        ]);

        // Redirect to appointments page
        return redirect()->route('patient.appointments');
    }

    public function bookAppointment($doctorId)
    {
        // Store the doctor ID and symptoms in session to pre-fill appointment form
        session([
            'recommended_doctor_id' => $doctorId,
            'symptoms_description' => $this->primarySymptom . '. ' . $this->description,
        ]);

        // Redirect to appointments page with the selected doctor pre-selected
        return redirect()->route('patient.appointments');
    }

    public function resetForm()
    {
        $this->reset([
            'primarySymptom',
            'description', 
            'additionalSymptoms',
            'severity',
            'showResults',
            'recommendedSpecialty',
            'recommendation',
            'suggestedDoctors',
            'suggestedDoctor', // ADDED THIS
            'aiAnalysis'
        ]);
    }

    public function render()
    {
        return view('livewire.patient.symptom-checker');
    }
}