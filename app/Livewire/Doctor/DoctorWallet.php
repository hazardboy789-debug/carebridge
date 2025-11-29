<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Appointment;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.doctor')]
class DoctorWallet extends Component
{
    use WithPagination;
    
    public $balance;
    public $earningsMonth;
    public $earningsWeek;
    public $pendingAmount;
    public $pendingCount;
    
    public function mount()
    {
        $this->loadDoctorStats();
    }
    
    public function loadDoctorStats()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        $this->balance = $wallet->balance;
        
        // Calculate earnings this month (consultation fees)
        $startOfMonth = now()->startOfMonth();
        $this->earningsMonth = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->where('description', 'like', '%consultation%')
            ->where('created_at', '>=', $startOfMonth)
            ->sum('amount');
        
        // Calculate earnings last 7 days
        $startOfWeek = now()->subDays(7);
        $this->earningsWeek = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->where('description', 'like', '%consultation%')
            ->where('created_at', '>=', $startOfWeek)
            ->sum('amount');
        
        // Calculate pending payments from completed appointments
        $this->pendingAmount = Appointment::where('doctor_id', $user->id)
            ->where('status', 'completed')
            ->where('payment_status', 'pending')
            ->sum('fee');
            
        $this->pendingCount = Appointment::where('doctor_id', $user->id)
            ->where('status', 'completed')
            ->where('payment_status', 'pending')
            ->count();
    }
    
    public function requestPayout()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        if ($wallet->balance > 0) {
            // Create payout transaction
            $transaction = WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'amount' => $wallet->balance,
                'description' => 'Payout request to bank account',
                'status' => 'pending',
                'reference_id' => 'PO_' . time() . '_' . $user->id
            ]);
            
            session()->flash('message', 'Payout request submitted successfully! Your funds will be transferred within 2-3 business days.');
        } else {
            session()->flash('error', 'Insufficient balance for payout.');
        }
        
        // Reload stats
        $this->loadDoctorStats();
    }
    
    public function processPendingPayments()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        // Get completed appointments with pending payments
        $pendingAppointments = Appointment::where('doctor_id', $user->id)
            ->where('status', 'completed')
            ->where('payment_status', 'pending')
            ->get();
        
        $totalProcessed = 0;
        
        foreach ($pendingAppointments as $appointment) {
            // Create credit transaction for each completed appointment
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $appointment->fee,
                'description' => 'Consultation fee - Appointment #' . $appointment->id,
                'status' => 'completed',
                'appointment_id' => $appointment->id,
                'reference_id' => 'FEE_' . time() . '_' . $appointment->id
            ]);
            
            // Update appointment payment status
            $appointment->update(['payment_status' => 'paid']);
            
            $totalProcessed += $appointment->fee;
        }
        
        // Update wallet balance
        if ($totalProcessed > 0) {
            $wallet->increment('balance', $totalProcessed);
            session()->flash('message', 'Successfully processed ' . $pendingAppointments->count() . ' pending payments totaling LKR ' . number_format($totalProcessed, 2));
        } else {
            session()->flash('info', 'No pending payments to process.');
        }
        
        // Reload stats
        $this->loadDoctorStats();
    }
    
    public function render()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $recentPayments = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Calculate actual earnings data for chart (last 7 days)
        $earningsData = [];
        $today = now();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $dayEarnings = WalletTransaction::where('wallet_id', $wallet->id)
                ->where('type', 'credit')
                ->where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('amount');
            
            $earningsData[] = [
                'date' => $date->format('D'),
                'amount' => $dayEarnings ?? 0,
            ];
        }

        return view('livewire.doctor.doctor-wallet', [
            'transactions' => $transactions,
            'recentPayments' => $recentPayments,
            'earningsData' => $earningsData,
            'earningsMonth' => $this->earningsMonth ?? 0,
            'earningsWeek' => $this->earningsWeek ?? 0,
            'pendingAmount' => $this->pendingAmount ?? 0,
            'pendingCount' => $this->pendingCount ?? 0,
        ]);
    }
}