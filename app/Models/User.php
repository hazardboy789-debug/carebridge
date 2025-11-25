<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // admin | doctor | patient | staff
        'contact',    // contact field
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // Remove is_active cast since it doesn't exist in database
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',
        'display_name',
        'is_active', // Virtual attribute since we don't have the database field
    ];

    /* -----------------------------
     | Relationships
     |------------------------------ */

    /**
     * User details (one-to-one) - for user profile information
     */
    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    /**
     * Patient details (one-to-one)
     */
    public function patientDetail()
    {
        return $this->hasOne(PatientDetail::class);
    }

    /**
     * Doctor details (one-to-one)
     */
    public function doctorDetail()
    {
        return $this->hasOne(DoctorDetail::class);
    }

    /**
     * Appointments where this user is the doctor
     */
    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Appointments where this user is the patient
     */
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }

    /**
     * General appointments relationship - returns appointments based on user role
     */
    public function appointments()
    {
        if ($this->isDoctor()) {
            return $this->doctorAppointments();
        } elseif ($this->isPatient()) {
            return $this->patientAppointments();
        }
        
        // For admin/staff, return empty relationship or all appointments they can access
        return $this->hasMany(Appointment::class, 'doctor_id')->whereRaw('1=0'); // Empty result
    }

    /**
     * Transactions (payments, payouts)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Pharmacy orders placed by this user
     */
    public function pharmacyOrders()
    {
        return $this->hasMany(PharmacyOrder::class);
    }

    /**
     * Get all appointments for this user (both as doctor and patient)
     */
    public function allAppointments()
    {
        if ($this->isDoctor()) {
            return $this->doctorAppointments();
        } elseif ($this->isPatient()) {
            return $this->patientAppointments();
        }
        
        return $this->doctorAppointments(); // Fallback
    }

    /* -----------------------------
     | Scopes
     |------------------------------ */

    /**
     * Scope for doctors
     */
    public function scopeDoctors($query)
    {
        return $query->where('role', 'doctor');
    }

    /**
     * Scope for patients
     */
    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }

    /**
     * Scope for admins
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for staff
     */
    public function scopeStaff($query)
    {
        return $query->where('role', 'staff');
    }

    /**
     * Scope for active users
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /* -----------------------------
     | Helper / role checks
     |------------------------------ */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isDoctor(): bool
    {
        return $this->role === 'doctor';
    }

    public function isPatient(): bool
    {
        return $this->role === 'patient';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Virtual is_active attribute - always return true since we don't have the field
     */
    public function getIsActiveAttribute(): bool
    {
        return true; // All users are active since we don't have the field
    }

    /**
     * Get the appropriate detail model based on role
     */
    public function getDetail()
    {
        if ($this->isDoctor()) {
            return $this->doctorDetail;
        } elseif ($this->isPatient()) {
            return $this->patientDetail;
        }
        
        return $this->userDetails;
    }

    /* -----------------------------
     | Attribute Accessors
     |------------------------------ */

    /**
     * Get display name (fallbacks)
     */
    public function getDisplayNameAttribute()
    {
        return $this->name ?? ($this->email ?? 'User #' . $this->id);
    }

    /**
     * Get formatted contact number
     */
    public function getFormattedContactAttribute()
    {
        return $this->contact ?: 'Not provided';
    }

    /**
     * Get role with proper formatting
     */
    public function getFormattedRoleAttribute()
    {
        return ucfirst($this->role);
    }

    /**
     * Virtual status badge - always active
     */
    public function getStatusBadgeAttribute()
    {
        return '<span class="badge bg-success">Active</span>';
    }

    /* -----------------------------
     | Methods
     |------------------------------ */

    /**
     * Get dashboard statistics for admin
     */
    public static function getDashboardStats()
    {
        return [
            'total_doctors' => self::doctors()->count(),
            'total_patients' => self::patients()->count(),
            'total_admins' => self::admins()->count(),
            'total_staff' => self::staff()->count(),
            'total_users' => self::count(),
        ];
    }

    /**
     * Check if user can be deleted
     */
    public function canBeDeleted(): bool
    {
        // Check if user has related records that would prevent deletion
        $hasAppointments = $this->doctorAppointments()->exists() || 
                          $this->patientAppointments()->exists();
        $hasTransactions = $this->transactions()->exists();
        $hasOrders = $this->pharmacyOrders()->exists();

        return !($hasAppointments || $hasTransactions || $hasOrders);
    }

    /**
     * Deactivate user
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
        return $this;
    }

    /**
     * Activate user
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
        return $this;
    }
}