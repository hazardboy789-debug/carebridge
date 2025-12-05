<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorDetail;
use App\Models\Appointment;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

#[Layout('components.layouts.doctor')]
class Profile extends Component
{
    use WithFileUploads;

    public $user;
    public $doctorDetail;
    
    // Profile fields
    public $name;
    public $email;
    public $contact;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    
    // Doctor specific fields
    public $specialization;
    public $license_number;
    public $experience_years;
    public $consultationFee = 0;
    public $qualification;
    public $bio;
    public $address;
    public $dob;
    public $gender;
    public $photo;

    public function mount()
    {
        $this->user = auth()->user();
        $this->doctorDetail = $this->user->doctorDetail;

        // Load current data
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->contact = $this->user->contact;

        if ($this->doctorDetail) {
            $this->specialization = $this->doctorDetail->specialization;
            $this->license_number = $this->doctorDetail->license_number;
            $this->experience_years = $this->doctorDetail->experience_years;
            $this->consultationFee = $this->doctorDetail->consultation_fee ?? 0;
            // The DB column is `description` for doctor details; map it to the qualification UI field
            $this->qualification = $this->doctorDetail->description;
            $this->bio = $this->doctorDetail->bio;
            $this->address = $this->doctorDetail->address;
            $this->dob = $this->doctorDetail->dob;
            $this->gender = $this->doctorDetail->gender;
        }
    }

    // Add this missing method that was being called
    public function saveProfile()
    {
        // Just call the existing updateProfile method
        $this->updateProfile();
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
            'contact' => 'nullable|string|max:20',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'experience_years' => 'required|integer|min:0',
            'qualification' => 'required|string|max:255',
            'consultationFee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'photo' => 'nullable|image|max:2048',
        ]);

        \DB::beginTransaction();
        try {
            // Update user
            $this->user->update([
                'name' => $this->name,
                'email' => $this->email,
                'contact' => $this->contact,
            ]);

            // Update or create doctor details
                if ($this->doctorDetail) {
                $this->doctorDetail->update([
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'experience_years' => $this->experience_years,
                    'consultation_fee' => $this->consultationFee,
                    // Persist qualification into the existing `description` column
                    'description' => $this->qualification,
                    'bio' => $this->bio,
                    'address' => $this->address,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                ]);
            } else {
                $this->doctorDetail = DoctorDetail::create([
                    'user_id' => $this->user->id,
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'experience_years' => $this->experience_years,
                    'consultation_fee' => $this->consultationFee,
                    // Persist qualification into the existing `description` column
                    'description' => $this->qualification,
                    'bio' => $this->bio,
                    'address' => $this->address,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                ]);
            }

            // Handle photo upload
            if ($this->photo) {
                $path = $this->photo->store('profile-photos', 'public');
                $this->user->update([
                    'profile_photo_path' => $path,
                ]);

                // Refresh user so subsequent calls see updated path, reset temp upload
                $this->user->refresh();
                $this->reset('photo');
            }

            \DB::commit();
            $this->dispatch('profile-updated');
            session()->flash('message', 'Profile updated successfully.');
        } catch (\Exception $e) {
            \DB::rollBack();
            session()->flash('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $this->user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
        session()->flash('message', 'Password updated successfully.');
    }

    public function deletePhoto()
    {
        if ($this->user->profile_photo_path) {
            // Delete the file from storage
            \Storage::disk('public')->delete($this->user->profile_photo_path);
            
            // Clear the path from database
            $this->user->update(['profile_photo_path' => null]);
            
            session()->flash('message', 'Profile photo removed.');
        }
    }

    public function render()
    {
        $avatar = null;
        if (!empty($this->user->profile_photo_path)) {
            $avatar = Storage::url($this->user->profile_photo_path);
        } elseif (!empty($this->user->profile_photo_url)) {
            $avatar = $this->user->profile_photo_url;
        } else {
            $avatar = $this->getDefaultAvatar();
        }

        return view('livewire.doctor.profile', [
            'profileCompletion' => $this->computeProfileCompletion(),
            'totalPatients' => $this->getTotalPatients(),
            'totalAppointments' => $this->getTotalAppointments(),
            'satisfactionRate' => $this->getSatisfactionRate(),
            'avatar' => $avatar,
        ]);
    }

    private function computeProfileCompletion()
    {
        $fields = [
            'name' => $this->name,
            'email' => $this->email,
            'contact' => $this->contact,
            'specialization' => $this->specialization,
            'license_number' => $this->license_number,
            'experience_years' => $this->experience_years,
            'qualification' => $this->qualification,
            'bio' => $this->bio,
            'address' => $this->address,
            'gender' => $this->gender,
            // 'dob' and 'photo' are optional, so don't count them in completion
        ];

        $total = count($fields);
        $filled = 0;
        
        foreach ($fields as $key => $value) {
            if (!empty($value)) {
                $filled++;
            }
        }

        if ($total === 0) return 0;

        return (int) round(($filled / $total) * 100);
    }

    private function getTotalPatients()
    {
        // Using distinct patients
        return Appointment::where('doctor_id', $this->user->id)
            ->distinct('patient_id')
            ->count('patient_id');
    }

    private function getTotalAppointments()
    {
        return Appointment::where('doctor_id', $this->user->id)->count();
    }

    private function getSatisfactionRate()
    {
        try {
            if (Schema::hasColumn('appointments', 'rating')) {
                $avg = Appointment::where('doctor_id', $this->user->id)
                    ->whereNotNull('rating')
                    ->avg('rating');
                return $avg ? round($avg, 1) : 5.0;
            }
        } catch (\Exception $e) {
            // Log error if needed
            \Log::error('Error calculating satisfaction rate: ' . $e->getMessage());
        }

        return 5.0; // default fallback
    }

    private function getDefaultAvatar()
    {
        // Return default avatar based on gender or initials
        if ($this->gender === 'female') {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=fce7f3&color=d946ef';
        } else {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=dbeafe&color=3b82f6';
        }
    }
}