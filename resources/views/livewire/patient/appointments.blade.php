<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Appointments
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage and schedule your medical appointments.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">New Appointment</span>
            </button>
        </div>

        <!-- Appointments Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Upcoming Appointments -->
            <div class="lg:col-span-2 flex flex-col gap-8">
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            Upcoming Appointments
                        </h2>
                        <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                    </div>
                    
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 3; $i++)
                        <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex flex-col items-center justify-center bg-primary/10 dark:bg-primary/20 text-primary w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">OCT</span>
                                <span class="text-2xl font-black">28</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Dr. Evelyn Reed
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Oncology Department
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                    10:30 AM
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    St. Jude's Hospital
                                </p>
                            </div>
                            <button class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                Join
                            </button>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Appointment History -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Appointment History
                    </h2>
                    <div class="flex flex-col gap-4">
                        @for($i = 0; $i < 2; $i++)
                        <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                            <div class="flex flex-col items-center justify-center bg-gray-100 dark:bg-slate-700 text-text-light-primary dark:text-text-dark-primary w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">SEP</span>
                                <span class="text-2xl font-black">15</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Dr. Michael Chen
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Cardiology Checkup
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Completed
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    09:00 AM
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
                            <span class="material-symbols-outlined">video_call</span>
                            Virtual Consultation
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">download</span>
                            Download Records
                        </button>
                        <button class="flex w-full items-center justify-center gap-2 rounded-lg h-11 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700">
                            <span class="material-symbols-outlined">share</span>
                            Share Appointment
                        </button>
                    </div>
                </div>

                <!-- Next Appointment -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Next Appointment
                    </h2>
                    <div class="bg-primary/10 dark:bg-primary/20 p-4 rounded-lg">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                            </div>
                            <div>
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Dr. Evelyn Reed
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    Oncologist
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-text-light-primary dark:text-text-dark-primary font-medium">Oct 28, 2024</span>
                            <span class="text-primary font-bold">10:30 AM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>