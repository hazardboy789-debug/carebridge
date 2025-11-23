<div>
    <div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Admin Dashboard
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Overview of your healthcare platform.
                </p>
            </div>
            <div class="flex flex-1 sm:flex-initial gap-3 flex-wrap justify-start">
                <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                    <span class="material-symbols-outlined">download</span>
                    <span class="truncate">Export Report</span>
                </button>
                <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-card-light dark:bg-card-dark text-text-light-primary dark:text-text-dark-primary border border-border-light dark:border-border-dark text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700 gap-2">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="truncate">Settings</span>
                </button>
            </div>
        </div>

        <!-- Quick Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Patients Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center rounded-full size-12 bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                        <span class="material-symbols-outlined">personal_injury</span>
                    </div>
                    <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                        +12%
                    </span>
                </div>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">Total Patients</p>
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">2,847</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">305 new this month</p>
                </div>
            </div>

            <!-- Doctors Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center rounded-full size-12 bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                        <span class="material-symbols-outlined">stethoscope</span>
                    </div>
                    <span class="bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded-full">
                        +5%
                    </span>
                </div>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">Active Doctors</p>
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">156</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">8 new this month</p>
                </div>
            </div>

            <!-- Appointments Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center rounded-full size-12 bg-purple-100 dark:bg-purple-900/20 text-purple-600 dark:text-purple-400">
                        <span class="material-symbols-outlined">calendar_month</span>
                    </div>
                    <span class="bg-orange-100 dark:bg-orange-900/20 text-orange-800 dark:text-orange-300 text-xs px-2 py-1 rounded-full">
                        Today
                    </span>
                </div>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">Today's Appointments</p>
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">47</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-sm text-green-500">schedule</span>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">12 upcoming</p>
                </div>
            </div>

            <!-- Transactions Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center justify-center rounded-full size-12 bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                    <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                        +18%
                    </span>
                </div>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-1">Total Revenue</p>
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">$24.5K</p>
                <div class="flex items-center gap-1 mt-2">
                    <span class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">$3.7k this month</p>
                </div>
            </div>
        </div>

        <!-- Charts and Additional Data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Activity -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        Recent Activity
                    </h2>
                    <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                </div>
                <div class="flex flex-col gap-4">
                    @for($i = 0; $i < 4; $i++)
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                        <div class="flex items-center justify-center rounded-full size-10 bg-primary/10 dark:bg-primary/20 text-primary">
                            <span class="material-symbols-outlined">person_add</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                New patient registration
                            </p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                John Doe registered as new patient
                            </p>
                        </div>
                        <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">2 hours ago</span>
                    </div>
                    @endfor
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                    System Status
                </h2>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Database</span>
                        </div>
                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">Operational</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">API Services</span>
                        </div>
                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">Operational</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-yellow-500">warning</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Payment Gateway</span>
                        </div>
                        <span class="bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 text-xs px-2 py-1 rounded-full">Maintenance</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-green-500">check_circle</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Email Services</span>
                        </div>
                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">Operational</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>