<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

#[Layout('components.layouts.admin')]

class WalletManager extends Component
{
    use WithPagination;
    
    public $totalBalance;
    public $totalWallets;
    public $transactionsToday;
    public $creditsToday;
    public $revenueMonth;
    public $revenueWeek;
    public $recentTransactions;
    public $walletActivity;
    
    public function mount()
    {
        $this->loadStats();
    }
    
    public function loadStats()
    {
        // Total balance across all wallets
        $this->totalBalance = Wallet::sum('balance');
        
        // Total active wallets
        $this->totalWallets = Wallet::count();
        
        // Transactions today
        $today = Carbon::today();
        $this->transactionsToday = WalletTransaction::whereDate('created_at', $today)->count();
        
        // Credits today
        $this->creditsToday = WalletTransaction::whereDate('created_at', $today)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Revenue this month
        $startOfMonth = Carbon::now()->startOfMonth();
        $this->revenueMonth = WalletTransaction::where('created_at', '>=', $startOfMonth)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Revenue last 7 days
        $startOfWeek = Carbon::now()->subDays(7);
        $this->revenueWeek = WalletTransaction::where('created_at', '>=', $startOfWeek)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Recent transactions
        $this->recentTransactions = WalletTransaction::with(['wallet.user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Wallet activity data for chart (last 7 days)
        $this->walletActivity = $this->getWalletActivityData();
    }
    
    private function getWalletActivityData()
    {
        $activityData = [];
        $today = Carbon::today();
        
        for ($i = 6; $i >= 0; $i--) {
            $date = $today->copy()->subDays($i);
            $formattedDate = $date->format('D');
            
            $credits = WalletTransaction::whereDate('created_at', $date)
                ->where('type', 'credit')
                ->where('status', 'completed')
                ->sum('amount');
                
            $debits = WalletTransaction::whereDate('created_at', $date)
                ->where('type', 'debit')
                ->where('status', 'completed')
                ->sum('amount');
            
            $activityData[] = [
                'date' => $formattedDate,
                'credits' => $credits ?? 0,
                'debits' => $debits ?? 0,
            ];
        }
        
        return $activityData;
    }
    
    public function render()
    {
        // Use paginate() instead of get() for the wallets
        $wallets = Wallet::with('user')->paginate(10);
        
        return view('livewire.admin.wallet-manager', [
            'wallets' => $wallets,
            'totalBalance' => $this->totalBalance,
            'totalWallets' => $this->totalWallets,
            'transactionsToday' => $this->transactionsToday,
            'creditsToday' => $this->creditsToday,
            'revenueMonth' => $this->revenueMonth,
            'revenueWeek' => $this->revenueWeek,
            'recentTransactions' => $this->recentTransactions,
            'walletActivity' => $this->walletActivity,
        ]);
    }

    /**
     * Add funds to a wallet. Only allowed for patient wallets.
     * Called from the Blade via Livewire.
     */
    public function addFunds($walletId, $amount, $note = null)
    {
        $amount = floatval($amount);

        if ($amount <= 0) {
            $this->dispatch('show-toast', type: 'error', message: 'Enter a valid amount');
            return;
        }

        $wallet = Wallet::with('user')->find($walletId);

        if (! $wallet) {
            $this->dispatch('show-toast', type: 'error', message: 'Wallet not found');
            return;
        }

        if (! $wallet->user || strtolower($wallet->user->role) !== 'patient') {
            $this->dispatch('show-toast', type: 'error', message: 'Can only add funds to patient wallets');
            return;
        }

        DB::transaction(function () use ($wallet, $amount, $note) {
            $wallet->balance = $wallet->balance + $amount;
            $wallet->save();

            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'credit',
                'amount' => $amount,
                'description' => $note ?? 'Admin added funds',
                'status' => 'completed',
                'reference_id' => null,
                'metadata' => ['added_by' => Auth::id()],
            ]);
        });

        // Refresh stats and send a success notification
        $this->loadStats();
        $this->dispatch('show-toast', type: 'success', message: 'Funds added successfully');
    }
}