<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PharmacyOrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'medicine_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(PharmacyOrder::class, 'order_id');
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(MedicineStock::class, 'medicine_id');
    }
}