<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SymptomCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'primary_symptom',
        'description',
        'additional_symptoms',
        'severity',
        'recommended_specialty',
        'recommendation',
        'suggested_doctors',
    ];

    protected $casts = [
        'additional_symptoms' => 'array',
        'suggested_doctors' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}