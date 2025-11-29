<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">My Wallet</h1>

    <!-- Balance Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Current Balance</div>
            <div class="text-2xl font-bold text-green-600">LKR {{ number_format($balance, 2) }}</div>
            <div class="text-xs text-gray-400 mt-1">Available for consultations</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Spent This Month</div>
            <div class="text-2xl font-bold text-red-600">LKR {{ number_format($spentMonth, 2) }}</div>
            <div class="text-xs text-gray-400">{{ $consultationsMonth }} consultations</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Health Credits</div>
            <div class="text-2xl font-bold text-blue-600">{{ $healthCredits }}</div>
            <div class="text-xs text-gray-400">Donations received</div>
        </div>
    </div>

    <!-- Add Funds + Quick Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-4">Add Funds to Wallet</h3>
            
            <!-- Quick Amount Buttons -->
            <div class="grid grid-cols-4 gap-3 mb-4">
                <button wire:click="setAmount(500)" class="p-3 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition 
                    {{ $amount == 500 ? 'bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-700' }}">
                    LKR 500
                </button>
                <button wire:click="setAmount(1000)" class="p-3 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition 
                    {{ $amount == 1000 ? 'bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-700' }}">
                    LKR 1,000
                </button>
                <button wire:click="setAmount(2000)" class="p-3 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition 
                    {{ $amount == 2000 ? 'bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-700' }}">
                    LKR 2,000
                </button>
                <button wire:click="setAmount(5000)" class="p-3 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50 transition 
                    {{ $amount == 5000 ? 'bg-blue-50 border-blue-500 text-blue-600' : 'text-gray-700' }}">
                    LKR 5,000
                </button>
            </div>

            <!-- Custom Amount Form -->
            <form wire:submit.prevent="addFunds">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Custom Amount</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">LKR</span>
                            </div>
                            <input type="number" wire:model="amount" 
                                   class="pl-12 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Enter amount" min="500" step="100">
                        </div>
                        @error('amount') 
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 p-4 focus:outline-none">
                                <input type="radio" name="payment_method" value="card" class="sr-only">
                                <div class="flex items-center">
                                    <div class="h-4 w-4 text-blue-600 border border-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <div class="h-2 w-2 rounded-full bg-blue-600"></div>
                                    </div>
                                    <span class="text-sm font-medium">Credit/Debit Card</span>
                                </div>
                            </label>
                            <label class="relative flex cursor-pointer rounded-lg border border-gray-300 p-4 focus:outline-none">
                                <input type="radio" name="payment_method" value="online" class="sr-only">
                                <div class="flex items-center">
                                    <div class="h-4 w-4 text-blue-600 border border-gray-300 rounded-full flex items-center justify-center mr-3">
                                        <div class="h-2 w-2 rounded-full bg-blue-600"></div>
                                    </div>
                                    <span class="text-sm font-medium">Online Banking</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-md text-sm font-medium hover:bg-blue-700 transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Add LKR {{ number_format($amount, 2) }} to Wallet
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-3">Quick Actions</h3>
            <div class="space-y-3">
                <button class="w-full bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-green-700 transition">
                    Request Health Credits
                </button>
                <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-50 transition">
                    Donate to Others
                </button>
                <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-50 transition">
                    View Spending Report
                </button>
            </div>

            <h4 class="font-semibold mt-6 mb-3">Recent Activity</h4>
            <ul class="divide-y">
                @foreach($recentActivity as $activity)
                    <li class="py-2">
                        <div class="text-sm">
                            <strong>{{ $activity->description }}</strong>
                            <span class="text-gray-500 text-xs"> • {{ $activity->status }}</span>
                        </div>
                        <div class="text-xs text-gray-600">
                            <span class="{{ $activity->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $activity->type === 'credit' ? '+' : '-' }}LKR {{ number_format($activity->amount, 2) }}
                            </span>
                            • {{ $activity->created_at->diffForHumans() }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Spending Chart + Upcoming Payments -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-2">Spending Overview (Last 7 Days)</h3>
            <canvas id="spendingChart" height="120"></canvas>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-3">Upcoming Payments</h3>
            @if($upcomingPayments->count() > 0)
                <ul class="divide-y">
                    @foreach($upcomingPayments as $payment)
                        <li class="py-3">
                            <div class="flex justify-between items-start">
                                <div>
                                    <div class="text-sm font-medium">{{ $payment->doctor->name ?? 'Consultation' }}</div>
                                    <div class="text-xs text-gray-500">{{ $payment->appointment_date->format('M d, H:i') }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-medium text-red-600">LKR {{ number_format($payment->fee, 2) }}</div>
                                    <div class="text-xs text-gray-500">Auto-pay</div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-sm text-gray-500 text-center py-4">No upcoming payments</p>
            @endif
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <div class="flex justify-between items-center mb-3">
            <h3 class="font-semibold">Transaction History</h3>
            <div class="flex space-x-2">
                <select class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                    <option value="">All Types</option>
                    <option value="credit">Credits</option>
                    <option value="debit">Debits</option>
                </select>
                <select class="border border-gray-300 rounded-md px-3 py-1 text-sm">
                    <option value="">All Time</option>
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Doctor</th>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Amount</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">
                                <div>{{ $transaction->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->created_at->format('H:i') }}</div>
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <div class="max-w-xs">{{ $transaction->description }}</div>
                                @if($transaction->appointment)
                                    <div class="text-xs text-gray-500">Appointment #{{ $transaction->appointment->id }}</div>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm">
                                @if($transaction->appointment && $transaction->appointment->doctor)
                                    {{ $transaction->appointment->doctor->name }}
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $transaction->type === 'credit' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm font-medium 
                                {{ $transaction->type === 'credit' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $transaction->type === 'credit' ? '+' : '-' }} LKR {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $transactions->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const data = @json($spendingData);

        const labels = data.map(d => d.date);
        const spending = data.map(d => d.amount);

        const ctx = document.getElementById('spendingChart').getContext('2d');

        if (window._spendingChart) {
            window._spendingChart.destroy();
        }

        window._spendingChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Spending',
                    data: spending,
                    backgroundColor: 'rgba(239, 68, 68, 0.5)',
                    borderColor: 'rgb(239, 68, 68)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'LKR ' + value;
                            }
                        }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });

    // Quick amount buttons functionality
    function setAmount(amount) {
        @this.set('amount', amount);
    }
</script>
@endpush