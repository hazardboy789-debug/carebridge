<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\PharmacyOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class AdminDashboard extends Component
{
    public $totalDoctors = 0;
    public $totalPatients = 0;
    public $totalAppointments = 0;
    public $appointmentsToday = 0;
    public $revenueMonth = 0;
    public $revenueWeek = 0;
    public $pendingOrders = 0;
    public $recentAppointments = [];
    public $recentTransactions = [];
    public $revenueSeries = [];

    protected $cacheTtl = 60;

    protected $listeners = [
        'refreshStats' => 'refreshStats'
    ];

    public function mount()
    {
        $this->refreshStats();
    }

    public function refreshStats()
    {
        // Basic counts
        $this->totalDoctors = Cache::remember('admin_total_doctors', $this->cacheTtl, function () {
            return User::where('role', 'doctor')->count();
        });

        $this->totalPatients = Cache::remember('admin_total_patients', $this->cacheTtl, function () {
            return User::where('role', 'patient')->count();
        });

        $this->totalAppointments = Cache::remember('admin_total_appointments', $this->cacheTtl, function () {
            return Schema::hasTable('appointments') ? Appointment::count() : 0;
        });

        // Appointments today
        $this->appointmentsToday = Cache::remember('admin_appointments_today', $this->cacheTtl, function () {
            if (!Schema::hasTable('appointments')) {
                return 0;
            }
            return Appointment::whereDate('appointment_date', Carbon::today())->count();
        });

        // Revenue calculations
        $this->revenueMonth = Cache::remember('admin_revenue_month', $this->cacheTtl, function () {
            if (!Schema::hasTable('transactions')) {
                return 0;
            }
            return (float) Transaction::whereBetween('created_at', [
                now()->startOfMonth(),
                now()->endOfMonth()
            ])->where('status', 'completed')->sum('amount');
        });

        $this->revenueWeek = Cache::remember('admin_revenue_week', $this->cacheTtl, function () {
            if (!Schema::hasTable('transactions')) {
                return 0;
            }
            return (float) Transaction::whereBetween('created_at', [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay()
            ])->where('status', 'completed')->sum('amount');
        });

        $this->pendingOrders = Cache::remember('admin_pending_orders', $this->cacheTtl, function () {
            if (!Schema::hasTable('pharmacy_orders')) {
                return 0;
            }
            return PharmacyOrder::where('status', 'pending')->count();
        });

        // Recent appointments
        $this->recentAppointments = Schema::hasTable('appointments') 
            ? Appointment::with(['doctor', 'patient'])
                ->orderBy('appointment_date', 'desc')
                ->take(7)
                ->get()
            : [];

        // Recent transactions
        $this->recentTransactions = Schema::hasTable('transactions') 
            ? Transaction::with('user')->orderBy('created_at', 'desc')->take(7)->get()
            : [];

        // Revenue series for chart
        $this->revenueSeries = Cache::remember('admin_revenue_series_7d', $this->cacheTtl, function () {
            if (!Schema::hasTable('transactions')) {
                return [];
            }
            
            $series = [];
            for ($i = 6; $i >= 0; $i--) {
                $day = now()->subDays($i);
                $sum = Transaction::whereDate('created_at', $day->toDateString())
                    ->where('status', 'completed')
                    ->sum('amount');
                $series[] = [
                    'date' => $day->format('Y-m-d'),
                    'label' => $day->format('M d'),
                    'amount' => (float) $sum,
                ];
            }
            return $series;
        });
    }

    public function formatMoney($amount)
    {
        return number_format($amount, 2);
    }

    public function render()
    {
        return view('livewire.admin.admin-dashboard');
    }
}