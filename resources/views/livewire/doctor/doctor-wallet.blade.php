<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">My Wallet</h1>

    <!-- Balance Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Current Balance</div>
            <div class="text-2xl font-bold text-green-600">LKR {{ number_format($balance, 2) }}</div>
            <div class="text-xs text-gray-400 mt-1">Available for withdrawal</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Earnings This Month</div>
            <div class="text-2xl font-bold">LKR {{ number_format($earningsMonth, 2) }}</div>
            <div class="text-xs text-gray-400">Last 7 days: LKR {{ number_format($earningsWeek, 2) }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Pending Payments</div>
            <div class="text-2xl font-bold text-yellow-600">LKR {{ number_format($pendingAmount, 2) }}</div>
            <div class="text-xs text-gray-400">{{ $pendingCount }} consultations</div>
        </div>
    </div>

    <!-- Quick Actions + Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow-sm">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold">Earnings Overview (Last 7 Days)</h3>
                <button wire:click="processPendingPayments" 
                        class="bg-blue-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-blue-700 transition">
                    Process Pending Payments
                </button>
            </div>
            <canvas id="earningsChart" height="120"></canvas>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-3">Quick Actions</h3>
            <div class="space-y-3">
                <button wire:click="requestPayout" 
                        class="w-full bg-green-600 text-white py-2 px-4 rounded-md text-sm font-medium hover:bg-green-700 transition">
                    Request Payout
                </button>
                <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-50 transition">
                    View Earnings Report
                </button>
                <button class="w-full border border-gray-300 text-gray-700 py-2 px-4 rounded-md text-sm font-medium hover:bg-gray-50 transition">
                    Tax Documents
                </button>
            </div>

            <h4 class="font-semibold mt-6 mb-3">Recent Payments</h4>
            <ul class="divide-y">
                @forelse($recentPayments as $payment)
                    <li class="py-2">
                        <div class="text-sm">
                            <strong>{{ $payment->description }}</strong>
                            <span class="text-gray-500 text-xs"> • {{ $payment->status }}</span>
                        </div>
                        <div class="text-xs text-gray-600">
                            LKR {{ number_format($payment->amount, 2) }} • {{ $payment->created_at->diffForHumans() }}
                        </div>
                    </li>
                @empty
                    <li class="py-2 text-sm text-gray-500 text-center">No recent payments</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <h3 class="font-semibold mb-3">Transaction History</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Patient</th>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Amount</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
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
                                @if($transaction->appointment && $transaction->appointment->patient)
                                    {{ $transaction->appointment->patient->name }}
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-4 text-sm text-center text-gray-500">
                                No transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const data = @json($earningsData);

        const labels = data.map(d => d.date);
        const earnings = data.map(d => d.amount);

        const ctx = document.getElementById('earningsChart').getContext('2d');

        if (window._earningsChart) {
            window._earningsChart.destroy();
        }

        window._earningsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Earnings',
                    data: earnings,
                    fill: true,
                    tension: 0.3,
                    borderWidth: 2,
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)'
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
</script>
@endpush