<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Transaction;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Transactions extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $transactions = Transaction::with('user')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('transaction_id', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q2) {
                          $q2->where('name', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Revenue stats
        $revenueStats = [
            'total' => Transaction::where('status', 'completed')->sum('amount'),
            'thisMonth' => Transaction::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
            'pending' => Transaction::where('status', 'pending')->sum('amount'),
        ];

        // Payment method stats (example)
        $paymentMethods = [
            ['name' => 'Credit Card', 'percentage' => 68],
            ['name' => 'Bank Transfer', 'percentage' => 22],
            ['name' => 'Digital Wallet', 'percentage' => 10],
        ];

        return view('livewire.admin.transactions', [
            'transactions' => $transactions,
            'revenueStats' => $revenueStats,
            'paymentMethods' => $paymentMethods
        ]);
    }
}