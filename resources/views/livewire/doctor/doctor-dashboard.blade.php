<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading & Button Group -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Good Morning, Dr. Reed
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Here's your schedule and practice overview for today.
                </p>
            </div>
            <div class="flex flex-1 sm:flex-initial gap-3 flex-wrap justify-start">
                <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                    <span class="material-symbols-outlined">add</span>
                    <span class="truncate">New Appointment</span>
                </button>
                <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-card-light dark:bg-card-dark text-text-light-primary dark:text-text-dark-primary border border-border-light dark:border-border-dark text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700 gap-2">
                    <span class="material-symbols-outlined">schedule</span>
                    <span class="truncate">Set Availability</span>
                </button>
            </div>
        </div>

        <!-- Dashboard Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Today's Schedule -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Today's Appointments
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 3; $i++)
                        <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex flex-col items-center justify-center bg-primary/10 dark:bg-primary/20 text-primary w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">{{ date('M') }}</span>
                                <span class="text-2xl font-black">{{ date('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Maria Garcia
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Follow-up Consultation
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    10:30 AM
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    45 mins
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                    Start
                                </button>
                                <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                    Reschedule
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Practice Statistics -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Practice Statistics
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View Reports</a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="material-symbols-outlined text-primary">groups</span>
                                <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Total Patients
                                </h3>
                            </div>
                            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">
                                247
                            </p>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                                <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">
                                    +12 this month
                                </p>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="material-symbols-outlined text-primary">calendar_month</span>
                                <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Weekly Appointments
                                </h3>
                            </div>
                            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">
                                38
                            </p>
                            <div class="flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                                <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">
                                    +5 from last week
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Earnings Summary -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-1">
                        Earnings Summary
                    </h2>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-4">
                        This month's revenue
                    </p>
                    <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg text-center mb-4">
                        <p class="text-primary text-4xl font-black tracking-tight">$8,245.50</p>
                    </div>
                    <div class="flex flex-col gap-3">
                        <button class="flex w-full items-center justify-center rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                            View Detailed Report
                        </button>
                        <button class="flex w-full items-center justify-center rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            Withdraw Funds
                        </button>
                    </div>
                </div>

                <!-- Notifications -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Notifications
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-center rounded-full size-8 bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                <span class="material-symbols-outlined text-sm">person_add</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-medium text-sm">
                                    New patient registration
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    John Smith registered for consultation
                                </p>
                            </div>
                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">2h ago</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-center rounded-full size-8 bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                                <span class="material-symbols-outlined text-sm">chat</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-medium text-sm">
                                    New message
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    Maria Garcia sent a message
                                </p>
                            </div>
                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">1h ago</span>
                        </div>
                        <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-center rounded-full size-8 bg-orange-100 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-medium text-sm">
                                    Appointment reminder
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    You have 3 appointments today
                                </p>
                            </div>
                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">30m ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>