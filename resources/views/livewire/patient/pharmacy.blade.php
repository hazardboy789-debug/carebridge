<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Pharmacy
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage your prescriptions and medication orders.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">New Order</span>
            </button>
        </div>

        <!-- Pharmacy Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <!-- Current Prescriptions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Current Prescriptions
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 3; $i++)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-12 bg-primary/10 dark:bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined">pill</span>
                                </div>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                        Metformin 500mg
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        Take one tablet twice daily with meals
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                        Refills: 2 remaining • Expires: Dec 15, 2024
                                    </p>
                                </div>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                Order Refill
                            </button>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Pharmacy Locations -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Nearby Pharmacies
                    </h2>
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 2; $i++)
                        <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-center rounded-full size-12 bg-green-100 dark:bg-green-900/20 text-green-600 dark:text-green-400">
                                <span class="material-symbols-outlined">local_pharmacy</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    CVS Pharmacy #1234
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    123 Main Street, Anytown • 0.8 miles away
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                    Open until 10:00 PM • 24/7 Pharmacy
                                </p>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                Directions
                            </button>
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
                            <span class="material-symbols-outlined">upload</span>
                            Upload Prescription
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">history</span>
                            Order History
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">local_shipping</span>
                            Track Delivery
                        </button>
                    </div>
                </div>

                <!-- Order Status -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Current Orders
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center justify-between mb-2">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    Order #PH-789123
                                </p>
                                <span class="bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 text-xs px-2 py-1 rounded-full">
                                    Processing
                                </span>
                            </div>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                Metformin 500mg, Lisinopril 10mg
                            </p>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                Estimated delivery: Tomorrow
                            </p>
                        </div>
                        
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-9 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                            Track All Orders
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>