<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\HealthVital;

#[Layout('components.layouts.patient')]
class VitalsTracker extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Form fields
    public $blood_pressure_systolic;
    public $blood_pressure_diastolic;
    public $heart_rate;
    public $blood_sugar;
    public $temperature;
    public $weight;
    public $notes;

    protected function rules()
    {
        return [
            'blood_pressure_systolic' => 'nullable|integer|between:70,250',
            'blood_pressure_diastolic' => 'nullable|integer|between:40,160',
            'heart_rate' => 'nullable|integer|between:20,220',
            'blood_sugar' => 'nullable|numeric|between:30,600',
            'temperature' => 'nullable|numeric|between:32,43',
            'weight' => 'nullable|numeric|between:1,350',
            'notes' => 'nullable|string|max:500',
        ];
    }

    public function save()
    {
        $this->validate();

        // Ensure at least one vital is provided
        $hasVital = $this->blood_pressure_systolic || $this->blood_pressure_diastolic ||
                    $this->heart_rate || $this->blood_sugar || $this->temperature || $this->weight;

        if (!$hasVital) {
            $this->addError('vitals_empty', 'Enter at least one vital sign.');
            return;
        }

        HealthVital::create([
            'user_id' => auth()->id(),
            'blood_pressure_systolic' => $this->blood_pressure_systolic,
            'blood_pressure_diastolic' => $this->blood_pressure_diastolic,
            'heart_rate' => $this->heart_rate,
            'blood_sugar' => $this->blood_sugar,
            'temperature' => $this->temperature,
            'weight' => $this->weight,
            'notes' => $this->notes,
        ]);

        $this->reset(['blood_pressure_systolic', 'blood_pressure_diastolic', 'heart_rate',
                      'blood_sugar', 'temperature', 'weight', 'notes']);
        $this->resetPage();

        session()->flash('success', 'Vitals saved successfully!');
    }

    public function delete($id)
    {
        HealthVital::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        session()->flash('success', 'Record deleted successfully.');
        $this->resetPage();
    }

    public function render()
    {
        $vitals = HealthVital::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $latest = HealthVital::where('user_id', auth()->id())
            ->latest()
            ->first();

        return view('livewire.patient.vitals-tracker', [
            'vitals' => $vitals,
            'latest' => $latest,
        ]);
    }
}