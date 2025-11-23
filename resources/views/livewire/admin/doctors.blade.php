<div>
    <div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Doctors Management
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage all healthcare providers and specialists.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">person_add</span>
                <span class="truncate">Add Doctor</span>
            </button>
        </div>

        <!-- Doctors Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Doctors Grid -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Healthcare Providers
                        </h2>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" placeholder="Search doctors..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-10 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="material-symbols-outlined">filter_list</span>
                            </button>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @for($i = 0; $i < 6; $i++)
                        <div class="bg-background-light dark:bg-background-dark p-4 rounded-lg border border-border-light dark:border-border-dark">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-14"
                                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                                </div>
                                <div class="flex-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                        Dr. Evelyn Reed
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        Oncology Specialist
                                    </p>
                                </div>
                                <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                    Available
                                </span>
                            </div>
                            <div class="flex items-center justify-between text-sm mb-3">
                                <span class="text-text-light-secondary dark:text-text-dark-secondary">Experience</span>
                                <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">12 years</span>
                            </div>
                            <div class="flex items-center justify-between text-sm mb-3">
                                <span class="text-text-light-secondary dark:text-text-dark-secondary">Patients</span>
                                <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">1,247</span>
                            </div>
                            <div class="flex items-center justify-between text-sm mb-4">
                                <span class="text-text-light-secondary dark:text-text-dark-secondary">Rating</span>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                    <span class="text-text-light-primary dark:text-text-dark-primary font-semibold">4.9</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <button class="flex-1 flex items-center justify-center gap-1 rounded-lg h-9 px-3 bg-primary text-white text-sm font-medium">
                                    <span class="material-symbols-outlined text-sm">visibility</span>
                                    View
                                </button>
                                <button class="flex-1 flex items-center justify-center gap-1 rounded-lg h-9 px-3 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                    <span class="material-symbols-outlined text-sm">edit</span>
                                    Edit
                                </button>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Specialization Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        By Specialization
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Cardiology</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">24</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Oncology</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">18</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Neurology</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">15</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Pediatrics</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">22</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Dermatology</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">12</span>
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
                            <span class="material-symbols-outlined">verified_user</span>
                            Verify Doctor
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">assignment</span>
                            Schedule Review
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">analytics</span>
                            Performance Report
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
