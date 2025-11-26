<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'symptoms',
        'notes',
        'fee'
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'fee' => 'decimal:2',
    ];

    // Relationship with patient
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    // Relationship with doctor
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}