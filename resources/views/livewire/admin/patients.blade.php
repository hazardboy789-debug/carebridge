<div>
    <div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Patients Management
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage all patient records and information.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">person_add</span>
                <span class="truncate">Add Patient</span>
            </button>
        </div>

        <!-- Patients Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Patients Table -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            All Patients
                        </h2>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Search patients..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
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
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Patient</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Contact</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Last Visit</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @for($i = 0; $i < 6; $i++)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A");'>
                                            </div>
                                            <div>
                                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                    Maria Garcia
                                                </p>
                                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                    ID: 789-123-456
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">maria.g@email.com</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">+1 (555) 123-4567</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                            Active
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">Oct 28, 2024</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Dr. Evelyn Reed</p>
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
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Quick Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Patient Stats
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Patients</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">2,847</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">New This Month</span>
                            <span class="text-green-600 dark:text-green-400 font-bold">+305</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Active Today</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">147</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Appointments</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">47</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Registrations -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Recent Registrations
                    </h2>
                    <div class="flex flex-col gap-3">
                        @for($i = 0; $i < 3; $i++)
                        <div class="flex items-center gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A");'>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    John Smith
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    Registered 2 hours ago
                                </p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
