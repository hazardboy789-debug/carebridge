<div>
    <div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Transactions & Revenue
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Monitor all financial transactions and revenue streams.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">download</span>
                <span class="truncate">Export Report</span>
            </button>
        </div>

        <!-- Transactions Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Revenue Overview -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Revenue Overview
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Total Revenue
                            </p>
                            <p class="text-primary text-2xl font-black tracking-tight">$24,580</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                This Month
                            </p>
                            <p class="text-green-600 dark:text-green-400 text-2xl font-black tracking-tight">$3,750</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Pending
                            </p>
                            <p class="text-blue-600 dark:text-blue-400 text-2xl font-black tracking-tight">$1,240</p>
                        </div>
                    </div>
                </div>

                <!-- Transactions Table -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Recent Transactions
                        </h2>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Search transactions..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="material-symbols-outlined">filter_list</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Transaction ID</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Patient</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Service</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Amount</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Date</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @for($i = 0; $i < 6; $i++)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                            TXN-789123
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-8"
                                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A");'>
                                            </div>
                                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm">Maria Garcia</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">Consultation</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Dr. Evelyn Reed</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                            $85.00
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">Oct 28, 2024</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">10:30 AM</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                            Completed
                                        </span>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Payment Methods -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Payment Methods
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-10 bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                    <span class="material-symbols-outlined">credit_card</span>
                                </div>
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Credit Card</span>
                            </div>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">68%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-10 bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                                    <span class="material-symbols-outlined">account_balance</span>
                                </div>
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Bank Transfer</span>
                            </div>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">22%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-10 bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
                                    <span class="material-symbols-outlined">payments</span>
                                </div>
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Digital Wallet</span>
                            </div>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">10%</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Financial Reports
                    </h2>
                    <div class="flex flex-col gap-3">
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                            <span class="material-symbols-outlined">receipt_long</span>
                            Generate Report
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">insights</span>
                            View Analytics
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">download</span>
                            Export Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
