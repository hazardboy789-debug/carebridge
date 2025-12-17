<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prescription extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'diagnosis',
        'medications',
        'instructions',
        'follow_up_date',
        'notes',
        'lab_tests',
        'signature_path',
        'pdf_path',
        'prescription_date',
        'status',
    ];

    protected $casts = [
        'medications' => 'array',
        'lab_tests' => 'array',
        'follow_up_date' => 'date',
        'prescription_date' => 'date',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function getPdfUrlAttribute()
    {
        return $this->pdf_path ? asset('storage/' . $this->pdf_path) : null;
    }
}