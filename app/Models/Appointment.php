<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date', // Correct column name
        'status',
        'symptoms',
        'diagnosis',
        'prescription',
        'notes',
        'fee',
        'payment_status',
    ];

    protected $casts = [
        'appointment_date' => 'datetime', // Correct column name
        'fee' => 'decimal:2',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}