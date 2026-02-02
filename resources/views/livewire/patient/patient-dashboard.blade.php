<!-- Page Content -->
<div class="flex-1 p-8">
                <div class="flex flex-col gap-8">
                    <!-- PageHeading & ButtonGroup -->
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex flex-col gap-1">
                            <p
                                class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                                Good Morning, {{ auth()->user()?->name ?? 'Patient' }}</p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                                Here's your summary for today.</p>
                        </div>
                        <div class="flex flex-1 sm:flex-initial gap-3 flex-wrap justify-start">
                            <button
                                class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                                <span class="material-symbols-outlined">playlist_add_check</span>
                                <span class="truncate">Start Symptom Check</span>
                            </button>
                            <button
                                class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-card-light dark:bg-card-dark text-text-light-primary dark:text-text-dark-primary border border-border-light dark:border-border-dark text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700 gap-2">
                                <span class="material-symbols-outlined">video_call</span>
                                <span class="truncate">Consult Doctor Now</span>
                            </button>
                        </div>
                    </div>
                    <!-- Dashboard Cards Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Left Column -->
                        <div class="lg:col-span-2 flex flex-col gap-8">
                            <!-- Upcoming Appointments removed -->
                            <!-- Health Summary -->
                            <div
                                class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                                        Your Health at a Glance</h2>
                                    <a class="text-primary text-sm font-bold hover:underline" href="#">View Full
                                        Record</a>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="material-symbols-outlined text-primary">bloodtype</span>
                                            <h3
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                White Blood Cell</h3>
                                        </div>
                                        <p
                                            class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">
                                            4.8 <span
                                                class="text-base font-normal text-text-light-secondary dark:text-text-dark-secondary">x10⁹/L</span>
                                        </p>
                                        <div class="flex items-center gap-1 mt-1">
                                            <span
                                                class="material-symbols-outlined text-sm text-green-500">arrow_upward</span>
                                            <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">
                                                Stable from last test</p>
                                        </div>
                                    </div>
                                    <div class="p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="material-symbols-outlined text-primary">scale</span>
                                            <h3
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Weight Trend</h3>
                                        </div>
                                        <p
                                            class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold">
                                            145 <span
                                                class="text-base font-normal text-text-light-secondary dark:text-text-dark-secondary">lbs</span>
                                        </p>
                                        <div class="flex items-center gap-1 mt-1">
                                            <span
                                                class="material-symbols-outlined text-sm text-red-500">arrow_downward</span>
                                            <p class="text-sm text-text-light-secondary dark:text-text-dark-secondary">
                                                -2 lbs from last week</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="lg:col-span-1 flex flex-col gap-8">
                            <!-- Wallet -->
                            <div
                                class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                                <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-1">
                                    My Wallet</h2>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-4">
                                    Available balance for services</p>
                                <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg text-center mb-4">
                                    <p class="text-primary text-4xl font-black tracking-tight">LKR {{ number_format(auth()->user()->wallet?->balance ?? 0, 2) }}</p>
                                </div>
                                <div class="flex flex-col gap-3">
                                    <button
                                        class="flex w-full items-center justify-center rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">Add
                                        Funds</button>
                                    <button
                                        class="flex w-full items-center justify-center rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">View
                                        Transactions</button>
                                </div>
                            </div>
                            <!-- Care Team removed -->
                        </div>
                    </div>
                </div>
</div>