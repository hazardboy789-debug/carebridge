<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\PharmacyOrder;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Pharmacy extends Component
{
    public function render()
    {
        // For now, we'll use static data since we don't have medication model
        // You can create a Medication model later
        
        $recentOrders = PharmacyOrder::with('user')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $stats = [
            'totalItems' => 156,
            'lowStock' => 12,
            'outOfStock' => 3,
            'categories' => 24,
        ];

        return view('livewire.admin.pharmacy', [
            'recentOrders' => $recentOrders,
            'stats' => $stats
        ]);
    }
}