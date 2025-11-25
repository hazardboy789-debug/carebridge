<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Patients extends Component
{
    use WithPagination;

    public $search = '';
    public $status = '';
    // Modal and form properties
    public $showCreateModal = false;

    // View modal
    public $viewModal = false;
    public $viewingPatient = null;

    public $name;
    public $email;
    public $password;
    public $contact;
    public $dob;
    public $age;
    public $address;
    public $gender;
    public $patient_status = 1;
    // Edit mode
    public $editing = false;
    public $editingId = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected $listeners = [
        'patientCreated' => '$refresh',
    ];

    public function render()
    {
        $patients = User::where('role', 'patient')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->with('userDetails')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Stats for the sidebar
        $stats = [
            'total' => User::where('role', 'patient')->count(),
            'newThisMonth' => User::where('role', 'patient')
                ->whereMonth('created_at', now()->month)
                ->count(),
            'activeToday' => 147, // You can implement this based on your logic
            'appointments' => 47, // You can implement this based on appointments
        ];

        return view('livewire.admin.patients', [
            'patients' => $patients,
            'stats' => $stats
        ]);
    }

    public function openCreateModal()
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

    public function openEditModal($id)
    {
        $user = User::with('userDetails')->find($id);
        if (! $user) {
            session()->flash('message', 'Patient not found.');
            return;
        }

        $this->resetValidation();
        $this->editing = true;
        $this->editingId = $user->id;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->contact = $user->contact;
        $this->dob = optional($user->userDetails)->dob;
        $this->age = optional($user->userDetails)->age;
        $this->address = optional($user->userDetails)->address;
        $this->gender = optional($user->userDetails)->gender;
        $this->patient_status = optional($user->userDetails)->status ?? 1;

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
            'age' => 'nullable|integer',
            'address' => 'nullable|string',
            'gender' => 'nullable|in:male,female,other',
            'patient_status' => 'nullable|in:0,1',
        ];
    }

    public function createPatient()
    {
        $this->validate();

        // create user and patient detail
        \DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password ?: Str::random(10)),
                'role' => 'patient',
                'contact' => $this->contact,
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'dob' => $this->dob,
                'age' => $this->age,
                'address' => $this->address,
                'gender' => $this->gender,
                'status' => $this->patient_status,
            ]);

            \DB::commit();

            session()->flash('message', 'Patient created successfully.');
            $this->closeCreateModal();
            $this->resetForm();
            $this->emit('patientCreated');
        } catch (\Throwable $e) {
            \DB::rollBack();
            $this->addError('create', 'Failed to create patient: ' . $e->getMessage());
        }
    }

    public function updatePatient()
    {
        $this->validate();

        if (! $this->editingId) {
            $this->addError('update', 'No patient selected for update.');
            return;
        }

        \DB::beginTransaction();
        try {
            $user = User::find($this->editingId);
            if (! $user) {
                session()->flash('message', 'Patient not found.');
                return;
            }

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
                'contact' => $this->contact,
            ]);

            $detail = $user->userDetails;
            if ($detail) {
                $detail->update([
                    'dob' => $this->dob,
                    'age' => $this->age,
                    'address' => $this->address,
                    'gender' => $this->gender,
                    'status' => $this->patient_status,
                ]);
            } else {
                UserDetail::create([
                    'user_id' => $user->id,
                    'dob' => $this->dob,
                    'age' => $this->age,
                    'address' => $this->address,
                    'gender' => $this->gender,
                    'status' => $this->patient_status,
                ]);
            }

            \DB::commit();

            session()->flash('message', 'Patient updated successfully.');
            $this->closeCreateModal();
            $this->resetForm();
            $this->editing = false;
            $this->editingId = null;
            $this->emit('patientCreated');
        } catch (\Throwable $e) {
            \DB::rollBack();
            $this->addError('update', 'Failed to update patient: ' . $e->getMessage());
        }
    }

    public function viewPatient($id)
    {
        $user = User::with('userDetails')->find($id);
        if (! $user) {
            session()->flash('message', 'Patient not found.');
            return;
        }
        $this->viewingPatient = $user;
        $this->viewModal = true;
    }

    public function closeViewModal()
    {
        $this->viewModal = false;
        $this->viewingPatient = null;
    }

    public function deletePatient($id)
    {
        \DB::beginTransaction();
        try {
            $user = User::find($id);
            if (! $user) {
                session()->flash('message', 'Patient not found.');
                return;
            }

            // delete related patient detail first
            if ($user->userDetails) {
                $user->userDetails()->delete();
            }

            $user->delete();

            \DB::commit();
            session()->flash('message', 'Patient deleted successfully.');
            $this->emit('patientCreated');
        } catch (\Throwable $e) {
            \DB::rollBack();
            $this->addError('delete', 'Failed to delete patient: ' . $e->getMessage());
        }
    }

    protected function resetForm()
    {
        $this->name = null;
        $this->email = null;
        $this->password = null;
        $this->contact = null;
        $this->dob = null;
        $this->age = null;
        $this->address = null;
        $this->gender = null;
        $this->patient_status = 1;
    }
}