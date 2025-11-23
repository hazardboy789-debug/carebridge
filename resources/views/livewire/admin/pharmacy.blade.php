<div>
    <div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Pharmacy Management
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage medication inventory and pharmacy orders.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">Add Medication</span>
            </button>
        </div>

        <!-- Pharmacy Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Inventory Overview -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Medication Inventory
                    </h2>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Medication</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Category</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Stock</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Price</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @for($i = 0; $i < 6; $i++)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center rounded-full size-10 bg-primary/10 dark:bg-primary/20 text-primary">
                                                <span class="material-symbols-outlined">pill</span>
                                            </div>
                                            <div>
                                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                    Metformin 500mg
                                                </p>
                                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                    Tablet, 90 count
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">Diabetes</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                            1,247
                                        </p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">units</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                            $24.99
                                        </p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                            In Stock
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <button class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                            <button class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </button>
                                            <button class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Recent Orders
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 3; $i++)
                        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-12 bg-blue-100 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                    <span class="material-symbols-outlined">local_shipping</span>
                                </div>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                        Order #PH-789123
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        Metformin, Lisinopril, Atorvastatin
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                        Patient: Maria Garcia • Total: $87.50
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 text-xs px-2 py-1 rounded-full">
                                    Processing
                                </span>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                    Oct 28, 2024
                                </p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Inventory Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Inventory Summary
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Items</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">156</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Low Stock</span>
                            <span class="text-orange-600 dark:text-orange-400 font-bold">12</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Out of Stock</span>
                            <span class="text-red-600 dark:text-red-400 font-bold">3</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Categories</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">24</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Quick Actions
                    </h2>
                    <div class="flex flex-col gap-3">
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-primary text-white text-sm font-bold">
                            <span class="material-symbols-outlined">inventory_2</span>
                            Update Stock
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">local_shipping</span>
                            Track Orders
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">assessment</span>
                            Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
