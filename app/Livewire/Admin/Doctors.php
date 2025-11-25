<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\DoctorDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Doctors extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    
    // Modal and form properties
    public $showCreateModal = false;
    public $viewModal = false;
    public $viewingDoctor = null;

    // Form fields
    public $name;
    public $email;
    public $password;
    public $contact;
    public $dob;
    public $gender;
    public $address;
    public $specialization;
    public $license_number;
    public $experience_years;
    public $description;
    public $doctor_status = 'pending';

    // Edit mode
    public $editing = false;
    public $editingId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'doctorCreated' => '$refresh',
    ];

    public function render()
    {
        $doctors = User::where('role', 'doctor')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->status !== '', function ($query) {
                $query->where('is_active', $this->status);
            })
            ->with('doctorDetail')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.doctors', [
            'doctors' => $doctors
        ]);
    }

    public function create()
    {
        $this->resetValidation();
        $this->resetForm();
        $this->showCreateModal = true;
        $this->editing = false;
        $this->editingId = null;
    }

    public function closeCreateModal()
    {
        $this->showCreateModal = false;
    }

    public function edit($id)
    {
        $user = User::with('doctorDetail')->find($id);
        if (!$user) {
            session()->flash('error', 'Doctor not found.');
            return;
        }

        $this->resetValidation();
        $this->editing = true;
        $this->editingId = $user->id;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->contact = $user->contact;
        $this->dob = optional($user->doctorDetail)->dob;
        $this->gender = optional($user->doctorDetail)->gender;
        $this->address = optional($user->doctorDetail)->address;
        $this->specialization = optional($user->doctorDetail)->specialization;
        $this->license_number = optional($user->doctorDetail)->license_number;
        $this->experience_years = optional($user->doctorDetail)->experience_years;
        $this->description = optional($user->doctorDetail)->description;
        $this->doctor_status = optional($user->doctorDetail)->status ?? 'pending';

        $this->showCreateModal = true;
    }

    protected function rules()
    {
        $emailRule = 'required|email';
        if ($this->editingId) {
            $emailRule .= '|unique:users,email,' . $this->editingId;
        } else {
            $emailRule .= '|unique:users,email';
        }

        return [
            'name' => 'required|string|max:255',
            'email' => $emailRule,
            'password' => 'nullable|string|min:6',
            'contact' => 'nullable|string|max:50',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'specialization' => 'required|string|max:255',
            'license_number' => 'required|string|max:100',
            'experience_years' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'doctor_status' => 'required|in:pending,approved,rejected',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->editing) {
            $this->updateDoctor();
        } else {
            $this->createDoctor();
        }
    }

    public function createDoctor()
    {
        \DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password ?: Str::random(10)),
                'role' => 'doctor',
                'contact' => $this->contact,
                'is_active' => true,
            ]);

            // Create doctor details in doctor_details table
            DoctorDetail::create([
                'user_id' => $user->id,
                'dob' => $this->dob,
                'gender' => $this->gender,
                'address' => $this->address,
                'specialization' => $this->specialization,
                'license_number' => $this->license_number,
                'experience_years' => $this->experience_years,
                'description' => $this->description,
                'status' => $this->doctor_status,
            ]);

            \DB::commit();

            session()->flash('message', 'Doctor created successfully.');
            $this->closeCreateModal();
            $this->resetForm();
            $this->dispatch('doctorCreated'); // FIXED: Changed emit to dispatch
        } catch (\Throwable $e) {
            \DB::rollBack();
            session()->flash('error', 'Failed to create doctor: ' . $e->getMessage());
        }
    }

    public function updateDoctor()
    {
        if (!$this->editingId) {
            session()->flash('error', 'No doctor selected for update.');
            return;
        }

        \DB::beginTransaction();
        try {
            $user = User::find($this->editingId);
            if (!$user) {
                session()->flash('error', 'Doctor not found.');
                return;
            }

            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'contact' => $this->contact,
            ];

            // Update password if provided
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }

            $user->update($userData);

            // Update doctor details in doctor_details table
            $detail = $user->doctorDetail;
            if ($detail) {
                $detail->update([
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                    'address' => $this->address,
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'experience_years' => $this->experience_years,
                    'description' => $this->description,
                    'status' => $this->doctor_status,
                ]);
            } else {
                DoctorDetail::create([
                    'user_id' => $user->id,
                    'dob' => $this->dob,
                    'gender' => $this->gender,
                    'address' => $this->address,
                    'specialization' => $this->specialization,
                    'license_number' => $this->license_number,
                    'experience_years' => $this->experience_years,
                    'description' => $this->description,
                    'status' => $this->doctor_status,
                ]);
            }

            \DB::commit();

            session()->flash('message', 'Doctor updated successfully.');
            $this->closeCreateModal();
            $this->resetForm();
            $this->editing = false;
            $this->editingId = null;
            $this->dispatch('doctorCreated'); // FIXED: Changed emit to dispatch
        } catch (\Throwable $e) {
            \DB::rollBack();
            session()->flash('error', 'Failed to update doctor: ' . $e->getMessage());
        }
    }

    public function toggleStatus($id)
    {
        try {
            $doctor = User::find($id);
            if ($doctor) {
                $doctor->update(['is_active' => !$doctor->is_active]);
                session()->flash('message', 'Doctor status updated successfully.');
                $this->dispatch('doctorCreated'); // FIXED: Changed emit to dispatch
            }
        } catch (\Throwable $e) {
            session()->flash('error', 'Failed to update doctor status: ' . $e->getMessage());
        }
    }

    public function deleteDoctor($id)
    {
        \DB::beginTransaction();
        try {
            $user = User::find($id);
            if (!$user) {
                session()->flash('error', 'Doctor not found.');
                return;
            }

            // Delete related doctor details first
            if ($user->doctorDetail) {
                $user->doctorDetail()->delete();
            }

            $user->delete();

            \DB::commit();
            session()->flash('message', 'Doctor deleted successfully.');
            $this->dispatch('doctorCreated'); // FIXED: Changed emit to dispatch
        } catch (\Throwable $e) {
            \DB::rollBack();
            session()->flash('error', 'Failed to delete doctor: ' . $e->getMessage());
        }
    }

    public function viewDoctor($id)
    {
        $user = User::with('doctorDetail')->find($id);
        if (!$user) {
            session()->flash('error', 'Doctor not found.');
            return;
        }
        $this->viewingDoctor = $user;
        $this->viewModal = true;
    }

    public function closeViewModal()
    {
        $this->viewModal = false;
        $this->viewingDoctor = null;
    }

    protected function resetForm()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->contact = null;
        $this->dob = null;
        $this->gender = null;
        $this->address = null;
        $this->specialization = null;
        $this->license_number = null;
        $this->experience_years = null;
        $this->description = null;
        $this->doctor_status = 'pending';
    }
}