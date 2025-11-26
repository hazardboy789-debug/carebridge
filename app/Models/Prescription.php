<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'diagnosis',
        'symptoms',
        'medicines',
        'instructions',
        'notes',
        'file_path',
        'follow_up_date',
    ];

    protected $casts = [
        'medicines' => 'array',
        'follow_up_date' => 'date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function getFormattedMedicinesAttribute()
    {
        return collect($this->medicines)->map(function ($medicine) {
            return "{$medicine['name']} - {$medicine['dosage']} - {$medicine['frequency']} - {$medicine['duration']}";
        });
    }
}