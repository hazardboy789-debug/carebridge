<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    My Wallet
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage your payments and transaction history.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">Add Funds</span>
            </button>
        </div>

        <!-- Wallet Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Balance Overview -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Balance Overview
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Available Balance
                            </p>
                            <p class="text-primary text-3xl font-black tracking-tight">$245.50</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Total Deposits
                            </p>
                            <p class="text-green-600 dark:text-green-400 text-3xl font-black tracking-tight">$500.00</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg text-center">
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">
                                Total Spent
                            </p>
                            <p class="text-blue-600 dark:text-blue-400 text-3xl font-black tracking-tight">$254.50</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Recent Transactions
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 4; $i++)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-10 bg-primary/10 dark:bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined">medical_services</span>
                                </div>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                        Consultation Fee
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        Dr. Evelyn Reed
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    -$85.00
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Oct 15, 2024
                                </p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Quick Actions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Quick Actions
                    </h2>
                    <div class="flex flex-col gap-3">
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                            <span class="material-symbols-outlined">add</span>
                            Add Funds
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">download</span>
                            Export Statements
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">credit_card</span>
                            Payment Methods
                        </button>
                    </div>
                </div>

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
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                        **** **** **** 4242
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                        Visa • Expires 12/25
                                    </p>
                                </div>
                            </div>
                            <span class="material-symbols-outlined text-text-light-secondary dark:text-text-dark-secondary">more_vert</span>
                        </div>
                        
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">add</span>
                            Add New Card
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>