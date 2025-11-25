<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorDetail extends Model
{
    use HasFactory;

    protected $table = 'doctor_details';

    protected $fillable = [
        'user_id',
        'dob',
        'gender',
        'address',
        'specialization',
        'license_number',
        'experience_years',
        'description',
        'status',
    ];

    /**
     * Relation: DoctorDetail belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
