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
        'scheduled_at', // This is the actual column name
        'appointment_time',
        'appointment_date',
        'status',
        'symptoms',
        'diagnosis',
        'prescription',
        'notes',
        'fee',
        'payment_status'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime', // This stores both date and time
        'appointment_date' => 'date',
        'fee' => 'decimal:2',
    ];

    // Payment status constants
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';
    const PAYMENT_REFUNDED = 'refunded';

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

    // Relationship with doctor details through user
    public function doctorDetail()
    {
        return $this->hasOneThrough(DoctorDetail::class, User::class, 'id', 'user_id', 'doctor_id', 'id');
    }

    // Accessor for appointment time (extract time from scheduled_at)
    public function getAppointmentTimeAttribute()
    {
        return $this->scheduled_at ? $this->scheduled_at->format('H:i') : null;
    }
}