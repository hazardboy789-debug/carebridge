<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    // Set primary key
    protected $primaryKey = 'user_details_id';

    // Mass assignable fields
    protected $fillable = [
        'user_id',
        'dob',
        'age',
        'address',
        'gender',
        'user_image',
        'description',
        'status',
    ];


    // Relationship: UserDetail belongs to a User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: UserDetail can have many attendances

}
