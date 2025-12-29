<div>
    <div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Wallet Management</h1>

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Total Balance</div>
            <div class="text-2xl font-bold">LKR {{ number_format($totalBalance, 2) }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Active Wallets</div>
            <div class="text-2xl font-bold">{{ $wallets->count() }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Transactions Today</div>
            <div class="text-2xl font-bold">{{ $transactionsToday }}</div>
            <div class="text-xs text-gray-400">Credits: LKR {{ number_format($creditsToday, 2) }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">This Month</div>
            <div class="text-2xl font-bold">LKR {{ number_format($revenueMonth, 2) }}</div>
            <div class="text-xs text-gray-400">Last 7 days: LKR {{ number_format($revenueWeek, 2) }}</div>
        </div>
    </div>

    <!-- Wallet Statistics + Recent Transactions -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="col-span-2 bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-2">Wallet Activity (Last 7 Days)</h3>
            <canvas id="walletChart" height="120"></canvas>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm">
            <h3 class="font-semibold mb-3">Recent Transactions</h3>
            <ul class="divide-y mt-2">
                @foreach($recentTransactions as $transaction)
                    <li class="py-2">
                        <div class="text-sm">
                            <strong>{{ $transaction->wallet->user->name }}</strong>
                            <span class="text-gray-500 text-xs"> — {{ $transaction->type }} • {{ $transaction->status }}</span>
                        </div>
                        <div class="text-xs text-gray-600">
                            LKR {{ number_format($transaction->amount, 2) }} • {{ $transaction->created_at->diffForHumans() }}
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Wallets Table -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <h3 class="font-semibold mb-3">All Wallets</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-3 py-2">User</th>
                        <th class="px-3 py-2">Email</th>
                        <th class="px-3 py-2">Role</th>
                        <th class="px-3 py-2">Balance</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Last Activity</th>
                        <th class="px-3 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wallets as $wallet)
                        <tr class="border-t">
                            <td class="px-3 py-2 text-sm">
                                <div class="font-medium">{{ $wallet->user->name }}</div>
                            </td>
                            <td class="px-3 py-2 text-sm">{{ $wallet->user->email }}</td>
                            <td class="px-3 py-2 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst($wallet->user->role) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm font-medium">
                                LKR {{ number_format($wallet->balance, 2) }}
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $wallet->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($wallet->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-500">
                                {{ $wallet->updated_at->diffForHumans() }}
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <button class="text-blue-600 hover:text-blue-900 text-xs font-medium">
                                    View Details
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $wallets->links() }}
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('livewire:load', function () {
        const data = @json($walletActivity);

        const labels = data.map(d => d.date);
        const credits = data.map(d => d.credits);
        const debits = data.map(d => d.debits);

        const ctx = document.getElementById('walletChart').getContext('2d');

        if (window._walletChart) {
            window._walletChart.destroy();
        }

        window._walletChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Credits',
                        data: credits,
                        backgroundColor: 'rgba(34, 197, 94, 0.5)',
                        borderColor: 'rgb(34, 197, 94)',
                        borderWidth: 1
                    },
                    {
                        label: 'Debits',
                        data: debits,
                        backgroundColor: 'rgba(239, 68, 68, 0.5)',
                        borderColor: 'rgb(239, 68, 68)',
                        borderWidth: 1
                    }
                ]
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
                }
            }
        });
    });
</script>
@endpush
    </div>