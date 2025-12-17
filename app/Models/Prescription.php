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
        'symptoms', // This exists in your DB
        'medicines', // This is 'medicines' not 'medications'
        'instructions',
        'notes',
        'file_path', // This is 'file_path' not 'signature_path' or 'pdf_path'
        'follow_up_date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'medicines' => 'array', // Cast medicines to array
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

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }
    
    // Helper method to get medicines as array
    public function getMedicinesListAttribute()
    {
        return is_array($this->medicines) ? $this->medicines : json_decode($this->medicines, true) ?? [];
    }
    
    // Helper method to get formatted medicines
    public function getFormattedMedicinesAttribute()
    {
        $medicines = $this->medicines_list;
        if (empty($medicines)) {
            return [];
        }
        
        $formatted = [];
        foreach ($medicines as $medicine) {
            $parts = explode('|', $medicine);
            $formatted[] = [
                'name' => $parts[0] ?? $medicine,
                'dosage' => $parts[1] ?? 'As directed',
                'frequency' => $parts[2] ?? 'Daily',
                'duration' => $parts[3] ?? '7 days',
            ];
        }
        
        return $formatted;
    }
}