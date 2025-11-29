<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Appointment;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;

#[Layout('components.layouts.patient')]
class PatientWallet extends Component
{
    use WithPagination;
    
    public $balance;
    public $amount = 500;
    public $paymentMethod = 'card';
    
    protected $rules = [
        'amount' => 'required|numeric|min:500',
        'paymentMethod' => 'required|in:card,online'
    ];
    
    public function mount()
    {
        // Get or create wallet and set balance
        $wallet = auth()->user()->getOrCreateWallet();
        $this->balance = $wallet->balance;
    }
    
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
    public function addFunds()
    {
        $this->validate();
        
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        // Create a pending transaction
        $transaction = WalletTransaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'credit',
            'amount' => $this->amount,
            'description' => 'Wallet top-up via ' . $this->paymentMethod,
            'status' => 'pending',
            'reference_id' => 'TXN_' . time() . '_' . $user->id
        ]);
        
        // Simulate successful payment (replace with actual payment gateway integration)
        $transaction->update(['status' => 'completed']);
        $wallet->increment('balance', $this->amount);
        
        // Update the balance
        $this->balance = $wallet->balance;
        $this->amount = 500; // Reset to default
        
        session()->flash('message', 'Funds added successfully!');
    }
    
    public function render()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        
        $transactions = WalletTransaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $recentActivity = WalletTransaction::where('wallet_id', $wallet->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $upcomingPayments = Appointment::where('patient_id', $user->id)
            ->where('status', 'confirmed')
            ->where('payment_status', 'pending')
            ->with('doctor')
            ->orderBy('appointment_date')
            ->limit(3)
            ->get();

        // Calculate actual stats
        $spentMonth = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'debit')
            ->where('status', 'completed')
            ->whereMonth('created_at', now()->month)
            ->sum('amount');

        $consultationsMonth = Appointment::where('patient_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->count();

        $healthCredits = WalletTransaction::where('wallet_id', $wallet->id)
            ->where('type', 'credit')
            ->where('description', 'like', '%donation%')
            ->count();

        // Mock data for charts
        $spendingData = [
            ['date' => 'Mon', 'amount' => 1500],
            ['date' => 'Tue', 'amount' => 2000],
            ['date' => 'Wed', 'amount' => 1200],
            ['date' => 'Thu', 'amount' => 1800],
            ['date' => 'Fri', 'amount' => 2500],
            ['date' => 'Sat', 'amount' => 1000],
            ['date' => 'Sun', 'amount' => 800],
        ];

        return view('livewire.patient.patient-wallet', [
            'transactions' => $transactions,
            'recentActivity' => $recentActivity,
            'upcomingPayments' => $upcomingPayments,
            'spendingData' => $spendingData,
            'spentMonth' => $spentMonth,
            'consultationsMonth' => $consultationsMonth,
            'healthCredits' => $healthCredits,
        ]);
    }
}