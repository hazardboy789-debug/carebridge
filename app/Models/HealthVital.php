<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HealthVital extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'blood_sugar',
        'temperature',
        'weight',
        'notes',
    ];

    /* --------------------------
     | RELATIONSHIP
     -------------------------- */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* --------------------------
     | BLOOD PRESSURE STATUS
     -------------------------- */
    public function getBloodPressureStatusAttribute()
    {
        $sys = $this->blood_pressure_systolic;
        $dia = $this->blood_pressure_diastolic;

        if (!$sys || !$dia) {
            return $this->unknown();
        }

        if ($sys >= 140 || $dia >= 90) {
            return $this->status('High (Stage 2)', 'red');
        }

        if ($sys >= 130 || $dia >= 80) {
            return $this->status('High (Stage 1)', 'orange');
        }

        if ($sys >= 120 && $dia < 80) {
            return $this->status('Elevated', 'blue');
        }

        return $this->status('Normal', 'green');
    }

    /* --------------------------
     | HEART RATE
     -------------------------- */
    public function getHeartRateStatusAttribute()
    {
        $hr = $this->heart_rate;

        if (!$hr) return $this->unknown();

        if ($hr > 100) {
            return $this->status('Tachycardia', 'red');
        }

        if ($hr < 60) {
            return $this->status('Bradycardia', 'blue');
        }

        return $this->status('Normal', 'green');
    }

    /* --------------------------
     | TEMPERATURE
     -------------------------- */
    public function getTemperatureStatusAttribute()
    {
        $temp = $this->temperature;

        if (!$temp) return $this->unknown();

        if ($temp > 37.5) {
            return $this->status('Fever', 'red');
        }

        if ($temp < 36) {
            return $this->status('Low Temp', 'blue');
        }

        return $this->status('Normal', 'green');
    }

    /* --------------------------
     | BLOOD SUGAR
     -------------------------- */
    public function getBloodSugarStatusAttribute()
    {
        $sugar = $this->blood_sugar;

        if (!$sugar) return $this->unknown();

        if ($sugar >= 126) {
            return $this->status('Diabetic', 'red');
        }

        if ($sugar >= 100) {
            return $this->status('Prediabetic', 'orange');
        }

        if ($sugar < 70) {
            return $this->status('Low Sugar', 'blue');
        }

        return $this->status('Normal', 'green');
    }

    /* --------------------------
     | REUSABLE HELPERS
     -------------------------- */
    private function status($text, $color)
    {
        return [
            'status' => $text,
            'color' => $color,
            'bg' => match ($color) {
                'red' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                'orange' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                'blue' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                default => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
            }
        ];
    }

    private function unknown()
    {
        return [
            'status' => 'Unknown',
            'color' => 'gray',
            'bg' => 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-300'
        ];
    }

    public function getOverallStatusAttribute(): array
{
    $statuses = [
        $this->blood_pressure_status['color'],
        $this->heart_rate_status['color'],
        $this->temperature_status['color'],
        $this->blood_sugar_status['color'],
    ];

    if (in_array('red', $statuses)) {
        return ['status' => 'Critical', 'color' => 'red', 'bg' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300'];
    }
    if (in_array('orange', $statuses)) {
        return ['status' => 'Warning', 'color' => 'orange', 'bg' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300'];
    }
    if (in_array('blue', $statuses)) {
        return ['status' => 'Attention Needed', 'color' => 'blue', 'bg' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300'];
    }
    return ['status' => 'Good', 'color' => 'green', 'bg' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'];
}
}