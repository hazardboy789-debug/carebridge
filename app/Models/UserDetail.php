<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'dob',
        'age',
        'address',
        'gender',
        'description',
        'status',
    ];

    protected $casts = [
        'dob' => 'date',
    ];

    /**
     * Get the user that owns the details.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted age
     */
    public function getFormattedAgeAttribute()
    {
        if ($this->age) {
            return $this->age . ' years';
        }
        
        if ($this->dob) {
            return $this->dob->age . ' years';
        }
        
        return 'Not specified';
    }
}