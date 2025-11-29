<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'description',
        'status',
        'reference_id',
        'appointment_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'amount' => 'decimal:2'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}