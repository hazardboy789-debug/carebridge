<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Transaction;
use App\Models\Appointment;

#[Layout('components.layouts.doctor')]
class Wallet extends Component
{
    use WithPagination;

    public $balance = 0;
    public $pendingBalance = 0;
    public $totalEarnings = 0;
    public $dateFilter = '';

    public function mount()
    {
        $this->loadWalletStats();
    }

    public function loadWalletStats()
    {
        $doctorId = auth()->id();

        // Completed appointments earnings (available balance)
        $this->balance = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->where('payment_status', 'paid')
            ->sum('fee') ?? 0;

        // Pending earnings (completed but not paid out)
        $this->pendingBalance = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->where('payment_status', 'pending')
            ->sum('fee') ?? 0;

        // Total lifetime earnings
        $this->totalEarnings = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'completed')
            ->sum('fee') ?? 0;
    }

    public function render()
    {
        $transactions = Appointment::with('patient')
            ->where('doctor_id', auth()->id())
            ->where('status', 'completed')
            ->when($this->dateFilter === 'week', function ($query) {
                $query->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()]);
            })
            ->when($this->dateFilter === 'month', function ($query) {
                $query->whereMonth('appointment_date', now()->month);
            })
            ->when($this->dateFilter === 'year', function ($query) {
                $query->whereYear('appointment_date', now()->year);
            })
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        return view('livewire.doctor.wallet', [
            'transactions' => $transactions,
            'stats' => [
                'balance' => $this->balance,
                'pending' => $this->pendingBalance,
                'total' => $this->totalEarnings,
            ]
        ]);
    }

    public function requestPayout()
    {
        // Logic for payout request
        if ($this->balance > 0) {
            // Create payout request
            session()->flash('message', 'Payout request submitted successfully.');
            $this->loadWalletStats();
        } else {
            session()->flash('error', 'No available balance for payout.');
        }
    }

    public function updatedDateFilter()
    {
        $this->resetPage();
    }
}