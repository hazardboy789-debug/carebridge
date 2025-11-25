<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    My Wallet
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    View your earnings and manage withdrawals.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2" wire:click="withdrawFunds">
                <span class="material-symbols-outlined">payments</span>
                <span class="truncate">Withdraw</span>
            </button>
        </div>

        <!-- Wallet Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Earnings Overview -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Earnings Overview
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Available Balance
                            </p>
                            <p class="text-primary text-2xl font-black tracking-tight">${{ number_format($availableBalance, 2) }}</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                This Month
                            </p>
                            <p class="text-green-600 dark:text-green-400 text-2xl font-black tracking-tight">${{ number_format($monthlyEarnings, 2) }}</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Total Earned
                            </p>
                            <p class="text-blue-600 dark:text-blue-400 text-2xl font-black tracking-tight">${{ number_format($totalEarnings, 2) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Transactions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Recent Transactions
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Date</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Description</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Patient</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Amount</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @forelse($transactions as $transaction)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $transaction->created_at->format('M d, Y') }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $transaction->created_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $transaction->description }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $transaction->type }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $transaction->patient->name ?? 'N/A' }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm {{ $transaction->amount >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                            {{ $transaction->amount >= 0 ? '+' : '' }}${{ number_format($transaction->amount, 2) }}
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-{{ $transaction->status === 'completed' ? 'green' : ($transaction->status === 'pending' ? 'yellow' : 'red') }}-100 dark:bg-{{ $transaction->status === 'completed' ? 'green' : ($transaction->status === 'pending' ? 'yellow' : 'red') }}-900/20 text-{{ $transaction->status === 'completed' ? 'green' : ($transaction->status === 'pending' ? 'yellow' : 'red') }}-800 dark:text-{{ $transaction->status === 'completed' ? 'green' : ($transaction->status === 'pending' ? 'yellow' : 'red') }}-300 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-text-light-secondary dark:text-text-dark-secondary">
                                        <span class="material-symbols-outlined text-4xl mb-2">account_balance_wallet</span>
                                        <p>No transactions found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Withdrawal Info -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Withdrawal
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="bg-background-light dark:bg-background-dark p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Available for Withdrawal
                            </p>
                            <p class="text-primary text-2xl font-black">${{ number_format($availableBalance, 2) }}</p>
                        </div>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                    Amount to Withdraw
                                </label>
                                <input type="number" wire:model="withdrawalAmount" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary text-sm focus:outline-none focus:ring-2 focus:ring-primary" placeholder="0.00" min="0" max="{{ $availableBalance }}">
                            </div>
                            
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                    Bank Account
                                </label>
                                <select class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option>**** **** **** 4242 - Primary</option>
                                    <option>**** **** **** 1234 - Savings</option>
                                </select>
                            </div>
                            
                            <button wire:click="processWithdrawal" class="w-full flex items-center justify-center gap-2 rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                                <span class="material-symbols-outlined">payments</span>
                                Process Withdrawal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Earnings Summary -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Earnings Summary
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">This Week</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">${{ number_format($weeklyEarnings, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">This Month</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">${{ number_format($monthlyEarnings, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">This Year</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">${{ number_format($yearlyEarnings, 2) }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Withdrawn</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">${{ number_format($totalWithdrawn, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>