<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;

    // Add fillable based on your actual table structure
    protected $fillable = [
        'name', 'owner_name', 'email', 'phone', 'address', 
        'latitude', 'longitude', 'license_number', 'status',
        'opening_time', 'closing_time', 'is_24_hours'
    ];

    protected $casts = [
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
        'is_24_hours' => 'boolean',
    ];

    //  Pharmacy model relationships
        public function medicineStock()
    {
    return $this->hasMany(MedicineStock::class);
    }

    public function activeMedicineStock()
    {
    return $this->hasMany(MedicineStock::class)->active();
    }       

    public function orders()
    {
        return $this->hasMany(PharmacyOrder::class);
    }

    public function getIsOpenAttribute()
    {
        if ($this->is_24_hours) return true;
        
        $now = now();
        $currentTime = $now->format('H:i:s');
        return $currentTime >= $this->opening_time && $currentTime <= $this->closing_time;
    }

    //medices relationship
    }