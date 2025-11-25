<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\DoctorDetail;
use Illuminate\Support\Facades\Hash;
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
            $this->qualification = $this->doctorDetail->qualification;
            $this->bio = $this->doctorDetail->bio;
            $this->address = $this->doctorDetail->address;
            $this->dob = $this->doctorDetail->dob;
            $this->gender = $this->doctorDetail->gender;
        }
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
                    'qualification' => $this->qualification,
                    'bio' => $this->bio,
                    'address' => $this->address,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                ]);
            } else {
                DoctorDetail::create([
                    'user_id' => $this->user->id,
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'experience_years' => $this->experience_years,
                    'qualification' => $this->qualification,
                    'bio' => $this->bio,
                    'address' => $this->address,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                ]);
            }

            // Handle photo upload
            if ($this->photo) {
                $this->user->updateProfilePhoto($this->photo);
            }

            \DB::commit();
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
        $this->user->deleteProfilePhoto();
        session()->flash('message', 'Profile photo removed.');
    }

    public function render()
    {
        return view('livewire.doctor.profile');
    }
}