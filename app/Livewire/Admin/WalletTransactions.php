<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\WalletTransaction;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class WalletTransactions extends Component
{
    use WithPagination;
    
    public $totalTransactions;
    public $totalCredits;
    public $totalDebits;
    public $completedTransactions;
    public $successRate;
    
    public function mount()
    {
        $this->loadStats();
    }
    
    public function loadStats()
    {
        $this->totalTransactions = WalletTransaction::count();
        $this->totalCredits = WalletTransaction::where('type', 'credit')->sum('amount');
        $this->totalDebits = WalletTransaction::where('type', 'debit')->sum('amount');
        $this->completedTransactions = WalletTransaction::where('status', 'completed')->count();
        
        // Calculate success rate safely to avoid division by zero
        $this->successRate = $this->totalTransactions > 0 
            ? number_format(($this->completedTransactions / $this->totalTransactions) * 100, 1)
            : 0;
    }
    
    public function render()
    {
        $transactions = WalletTransaction::with(['wallet.user', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('livewire.admin.wallet-transactions', [
            'transactions' => $transactions,
            'totalTransactions' => $this->totalTransactions,
            'totalCredits' => $this->totalCredits,
            'totalDebits' => $this->totalDebits,
            'completedTransactions' => $this->completedTransactions,
            'successRate' => $this->successRate,
        ]);
    }
}