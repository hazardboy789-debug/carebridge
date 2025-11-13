<?php

namespace App\Livewire\Landing;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\UserDetail;

#[Layout('components.layouts.landing')]

class IndexPage extends Component
{
    public $name;
    public $email;
    public $contact;
    public $password;
    public $password_confirmation;
    public $dob;
    public $age;
    public $address;
    public $gender;
    public $description;

    public $successMessage = null;
    public $errorMessage = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'contact' => 'required|string|max:30',
        'password' => 'required|min:6|confirmed',
        'dob' => 'nullable|date',
        'age' => 'nullable|integer|min:0',
        'address' => 'nullable|string|max:255',
        'gender' => 'nullable|in:male,female,other',
        'description' => 'nullable|string|max:500',
    ];

    protected $messages = [
        'name.required' => 'Please enter your name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already registered.',
        'contact.required' => 'Please enter your contact number.',
        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 6 characters.',
        'password.confirmed' => 'Password confirmation does not match.',
    ];

    public function register()
    {
        $this->resetMessages();
        
        // Validate the form
        $this->validate();

        DB::beginTransaction();
        try {
            // Create the user
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'contact' => $this->contact,
                'password' => Hash::make($this->password),
                'role' => 'patient',
            ]);

            // Create user details
            UserDetail::create([
                'user_id' => $user->id,
                'dob' => $this->dob,
                'age' => $this->age,
                'address' => $this->address,
                'gender' => $this->gender,
                'description' => $this->description,
                'status' => 'active',
            ]);

            DB::commit();
            
            // Set success message
            $this->successMessage = 'Registration successful! Redirecting to login...';
            
            // Log the user in
            Auth::login($user);
            
            // Close modal and redirect
            $this->dispatch('close-register-modal');
            
            // Redirect to patient dashboard
            session()->flash('success', 'Welcome! Your account has been created successfully.');
            return redirect()->route('patient.dashboard');
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->errorMessage = 'Registration failed. Please try again. Error: ' . $e->getMessage();
            Log::error('Registration Error: ' . $e->getMessage());
        }
    }

    public function resetMessages()
    {
        $this->successMessage = null;
        $this->errorMessage = null;
    }

    public function mount()
    {
        // Reset form when component is mounted
        $this->reset([
            'name', 'email', 'contact', 'password', 
            'password_confirmation', 'dob', 'age', 
            'address', 'gender', 'description'
        ]);
    }

    public function render()
    {
        return view('livewire.landing.index-page');
    }
}
