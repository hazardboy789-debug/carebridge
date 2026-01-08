<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDetail extends Model
{
    use HasFactory;

    protected $table = 'patient_details';

    protected $fillable = [
        'user_id',
        'dob',
        'age',
        'address',
        'gender',
        'status',
        'description',
    ];

    /**
     * Relation: PatientDetail belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
