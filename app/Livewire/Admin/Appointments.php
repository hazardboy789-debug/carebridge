<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Appointments extends Component
{
    use WithPagination;

    public $search = '';
    public $dateRange = 'All';
    public $status = '';
    public $doctor = '';
    public $type = '';

    public $doctors = [];
    public $startDate = null;
    public $endDate = null;

    public function mount()
    {
        // Set default date for today if needed
        if ($this->dateRange === 'Custom Range') {
            $this->startDate = now()->startOfMonth()->format('Y-m-d');
            $this->endDate = now()->endOfMonth()->format('Y-m-d');
        }
    }

    public function updatedDateRange($value)
    {
        if ($value === 'Custom Range') {
            if (!$this->startDate) {
                $this->startDate = now()->startOfMonth()->format('Y-m-d');
            }
            if (!$this->endDate) {
                $this->endDate = now()->endOfMonth()->format('Y-m-d');
            }
        } else {
            $this->startDate = null;
            $this->endDate = null;
        }

        $this->resetPage();
    }

    public function updating($property, $value)
    {
        if (in_array($property, ['search', 'dateRange', 'status', 'doctor', 'type', 'startDate', 'endDate'])) {
            $this->resetPage();
        }
    }

    public function applyFilters($query)
    {
        return $query
            // Search filter (also try parsing date strings to match scheduled_at)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('patient', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('doctor', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%')
                           ->orWhere('email', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('notes', 'like', '%' . $this->search . '%');

                    try {
                        $parsed = Carbon::parse($this->search)->toDateString();
                        $q->orWhereDate('scheduled_at', $parsed);
                    } catch (\Exception $e) {
                        // not a date string; ignore
                    }
                });
            })
            // Status filter - FIXED: Check for empty or "All Status"
            ->when(!empty($this->status) && $this->status !== 'All Status', function($query) {
                return $query->where('status', $this->status);
            })
            // Doctor filter - FIXED: Check for empty string
            ->when(!empty($this->doctor), function($query) {
                return $query->where('doctor_id', $this->doctor);
            })
            // Type filter - handle 'virtual' explicitly; treat in-person as not-virtual or null
            ->when(!empty($this->type) && $this->type !== 'All Types', function($query) {
                $typeVal = strtolower($this->type);
                if (Schema::hasColumn('appointments', 'type')) {
                    return $query->where('type', $typeVal === 'in-person' ? 'in_person' : $typeVal);
                } elseif (Schema::hasColumn('appointments', 'appointment_time')) {
                    if ($typeVal === 'virtual') {
                        return $query->where('appointment_time', 'virtual');
                    }
                    // in-person: appointment_time may be null or not 'virtual'
                    return $query->where(function($q) {
                        $q->whereNull('appointment_time')->orWhere('appointment_time', '!=', 'virtual');
                    });
                }
                return $query;
            })
            // Date range filter
            ->when($this->dateRange, function($query) {
                $today = Carbon::today();
                
                switch ($this->dateRange) {
                    case 'Today':
                        return $query->whereDate('scheduled_at', $today);
                        
                    case 'This Week':
                        return $query->whereBetween('scheduled_at', [
                            $today->copy()->startOfWeek(),
                            $today->copy()->endOfWeek()
                        ]);
                        
                    case 'This Month':
                        return $query->whereBetween('scheduled_at', [
                            $today->copy()->startOfMonth(),
                            $today->copy()->endOfMonth()
                        ]);
                        
                    case 'Custom Range':
                        // Support both-bounds and single-bound ranges
                        if ($this->startDate && $this->endDate) {
                            return $query->whereBetween('scheduled_at', [
                                Carbon::parse($this->startDate)->startOfDay(),
                                Carbon::parse($this->endDate)->endOfDay()
                            ]);
                        }

                        if ($this->startDate && ! $this->endDate) {
                            return $query->where('scheduled_at', '>=', Carbon::parse($this->startDate)->startOfDay());
                        }

                        if (! $this->startDate && $this->endDate) {
                            return $query->where('scheduled_at', '<=', Carbon::parse($this->endDate)->endOfDay());
                        }

                        return $query;
                        
                    case 'All':
                    default:
                        return $query;
                }
            });
    }

    public function calculateTodayStats()
    {
        $today = Carbon::today();
        
        $todayQuery = Appointment::whereDate('scheduled_at', $today);
        
        // Apply same filters to stats (except date filter)
        if ($this->search) {
            $todayQuery->where(function ($q) {
                $q->whereHas('patient', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                       ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                ->orWhereHas('doctor', function ($q2) {
                    $q2->where('name', 'like', '%' . $this->search . '%')
                       ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            });
        }
        
        // FIXED: Check for "All Status"
        if ($this->status && $this->status !== 'All Status') {
            $todayQuery->where('status', $this->status);
        }
        
        // FIXED: Check for empty string
        if (!empty($this->doctor)) {
            $todayQuery->where('doctor_id', $this->doctor);
        }
        
        // Check for "All Types" and map virtual vs in-person properly
        if ($this->type && $this->type !== 'All Types') {
            $typeVal = strtolower($this->type);
            if (Schema::hasColumn('appointments', 'type')) {
                $todayQuery->where('type', $typeVal === 'in-person' ? 'in_person' : $typeVal);
            } elseif (Schema::hasColumn('appointments', 'appointment_time')) {
                if ($typeVal === 'virtual') {
                    $todayQuery->where('appointment_time', 'virtual');
                } else {
                    $todayQuery->where(function($q) {
                        $q->whereNull('appointment_time')->orWhere('appointment_time', '!=', 'virtual');
                    });
                }
            }
        }

        $total = $todayQuery->count();
        $completed = (clone $todayQuery)->where('status', 'completed')->count();
        $confirmed = (clone $todayQuery)->where('status', 'confirmed')->count();
        $scheduled = (clone $todayQuery)->where('status', 'scheduled')->count();
        $cancelled = (clone $todayQuery)->where('status', 'cancelled')->count();
        $pending = (clone $todayQuery)->where('status', 'pending')->count();

        return [
            'total' => $total,
            'completed' => $completed,
            'confirmed' => $confirmed,
            'scheduled' => $scheduled,
            'upcoming' => $scheduled + $confirmed, // upcoming appointments
            'cancelled' => $cancelled,
            'pending' => $pending,
        ];
    }

    public function getTodayAppointments()
    {
        $today = Carbon::today();
        
        $query = Appointment::with(['patient', 'doctor'])
            ->whereDate('scheduled_at', $today)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('patient', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('doctor', function ($q2) {
                        $q2->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            // FIXED: Check for "All Status"
            ->when(!empty($this->status) && $this->status !== 'All Status', function($query) {
                $query->where('status', $this->status);
            })
            // FIXED: Check for empty string
            ->when(!empty($this->doctor), function($query) {
                $query->where('doctor_id', $this->doctor);
            })
            // Check for "All Types" and map virtual vs in-person properly
            ->when(!empty($this->type) && $this->type !== 'All Types', function($query) {
                $typeVal = strtolower($this->type);
                if (Schema::hasColumn('appointments', 'type')) {
                    return $query->where('type', $typeVal === 'in-person' ? 'in_person' : $typeVal);
                } elseif (Schema::hasColumn('appointments', 'appointment_time')) {
                    if ($typeVal === 'virtual') {
                        return $query->where('appointment_time', 'virtual');
                    }
                    return $query->where(function($q) {
                        $q->whereNull('appointment_time')->orWhere('appointment_time', '!=', 'virtual');
                    });
                }
                return $query;
            });

        return $query->orderBy('scheduled_at', 'asc')->get();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'dateRange', 'status', 'doctor', 'type', 'startDate', 'endDate']);
        $this->resetPage();
    }

    public function searchAppointments()
    {
        // Explicit trigger for applying filters from the UI search button
        $this->resetPage();
    }

    public function getStatusColor($status)
    {
        return match($status) {
            'completed' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-100',
            'confirmed' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-100',
            'scheduled' => 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-100',
            'pending' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-100',
            'cancelled' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-100',
            default => 'bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-100',
        };
    }

    // Computed property helper for Blade: $hasActiveFilters
    public function getHasActiveFiltersProperty()
    {
        $hasSearch = is_string($this->search) ? trim($this->search) !== '' : !empty($this->search);
        $hasStatus = !empty($this->status) && $this->status !== 'All Status';
        $hasDoctor = !empty($this->doctor);
        $hasType = !empty($this->type) && $this->type !== 'All Types';
        $hasDateRange = $this->dateRange && $this->dateRange !== 'All';
        $hasCustomDates = !empty($this->startDate) || !empty($this->endDate);

        return $hasSearch || $hasStatus || $hasDoctor || $hasType || $hasDateRange || $hasCustomDates;
    }

    public function render()
    {
        $this->doctors = User::whereHas('doctorDetail')
            ->orWhere('role', 'doctor')
            ->get(['id', 'name', 'email']);

        $appointments = Appointment::with(['patient', 'doctor.doctorDetail'])
            ->when(true, function($query) {
                return $this->applyFilters($query);
            })
            ->orderBy('scheduled_at', 'desc')
            ->paginate(10);

        $todayStats = $this->calculateTodayStats();
        $todayAppointments = $this->getTodayAppointments();

        return view('livewire.admin.appointments', [
            'appointments' => $appointments,
            'todayStats' => $todayStats,
            'todayAppointments' => $todayAppointments,
            'hasActiveFilters' => $this->hasActiveFilters,
        ]);
    }
}