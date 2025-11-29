<div class="p-6">
    <h1 class="text-2xl font-semibold mb-4">Wallet Transactions</h1>

    <!-- Filter Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Total Transactions</div>
            <div class="text-2xl font-bold">{{ $totalTransactions }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Total Credits</div>
            <div class="text-2xl font-bold text-green-600">LKR {{ number_format($totalCredits, 2) }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Total Debits</div>
            <div class="text-2xl font-bold text-red-600">LKR {{ number_format($totalDebits, 2) }}</div>
        </div>

        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="text-sm text-gray-500">Completed</div>
            <div class="text-2xl font-bold">{{ $completedTransactions }}</div>
            <div class="text-xs text-gray-400">
                @if($totalTransactions > 0)
                    {{ $successRate }}% success rate
                @else
                    No transactions
                @endif
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white p-4 rounded-lg shadow-sm mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="">All Types</option>
                    <option value="credit">Credit</option>
                    <option value="debit">Debit</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
                    <option value="">All Status</option>
                    <option value="completed">Completed</option>
                    <option value="pending">Pending</option>
                    <option value="failed">Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm">
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
        <h3 class="font-semibold mb-3">All Transactions</h3>

        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="text-left text-xs text-gray-500">
                        <th class="px-3 py-2">Date & Time</th>
                        <th class="px-3 py-2">User</th>
                        <th class="px-3 py-2">Type</th>
                        <th class="px-3 py-2">Amount</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Status</th>
                        <th class="px-3 py-2">Reference</th>
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
                                <div class="font-medium">{{ $transaction->wallet->user->name ?? 'N/A' }}</div>
                                <div class="text-xs text-gray-500">{{ $transaction->wallet->user->email ?? 'N/A' }}</div>
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
                                <div class="max-w-xs truncate">{{ $transaction->description }}</div>
                                @if($transaction->appointment)
                                    <div class="text-xs text-gray-500">Appointment #{{ $transaction->appointment->id }}</div>
                                @endif
                            </td>
                            <td class="px-3 py-2 text-sm">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $transaction->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                       ($transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 text-sm text-gray-500 font-mono text-xs">
                                {{ $transaction->reference_id ?? 'N/A' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 py-4 text-sm text-center text-gray-500">
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