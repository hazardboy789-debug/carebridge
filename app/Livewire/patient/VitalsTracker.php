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

    public $blood_pressure_systolic;
    public $blood_pressure_diastolic;
    public $heart_rate;
    public $blood_sugar;
    public $temperature;
    public $weight;
    public $notes;

    protected $rules = [
        'blood_pressure_systolic' => 'nullable|integer',
        'blood_pressure_diastolic' => 'nullable|integer',
        'heart_rate' => 'nullable|integer',
        'blood_sugar' => 'nullable|numeric',
        'temperature' => 'nullable|numeric',
        'weight' => 'nullable|numeric',
        'notes' => 'nullable|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        // ensure user exists
        if (!auth()->check()) {
            session()->flash('error', 'User not logged in');
            return;
        }

        // at least one value required
        if (
            !$this->blood_pressure_systolic &&
            !$this->blood_pressure_diastolic &&
            !$this->heart_rate &&
            !$this->blood_sugar &&
            !$this->temperature &&
            !$this->weight
        ) {
            $this->addError('vitals_empty', 'Enter at least one vital');
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

        $this->reset();
        $this->resetPage();

        session()->flash('success', 'Vitals saved successfully!');
    }

    public function delete($id)
    {
        HealthVital::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        session()->flash('success', 'Deleted successfully');
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