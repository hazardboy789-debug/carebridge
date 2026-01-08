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
                            <!-- Upcoming Appointments -->
                            <div
                                class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                                <div class="flex items-center justify-between mb-4">
                                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                                        Your Upcoming Appointments</h2>
                                    <a class="text-primary text-sm font-bold hover:underline" href="#">View All</a>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                        <div
                                            class="flex flex-col items-center justify-center bg-primary/10 dark:bg-primary/20 text-primary w-16 h-16 rounded-lg p-2">
                                            <span class="text-sm font-bold">OCT</span>
                                            <span class="text-2xl font-black">28</span>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Dr. Evelyn Reed</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Oncology Department</p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                10:30 AM</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                St. Jude's Hospital</p>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                        <div
                                            class="flex flex-col items-center justify-center bg-gray-100 dark:bg-slate-700 text-text-light-primary dark:text-text-dark-primary w-16 h-16 rounded-lg p-2">
                                            <span class="text-sm font-bold">NOV</span>
                                            <span class="text-2xl font-black">05</span>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Radiology Scan</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Imaging Center</p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                02:00 PM</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                City Health Clinic</p>
                                        </div>
                                    </div>
                                    <div
                                        class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                        <div
                                            class="flex flex-col items-center justify-center bg-gray-100 dark:bg-slate-700 text-text-light-primary dark:text-text-dark-primary w-16 h-16 rounded-lg p-2">
                                            <span class="text-sm font-bold">NOV</span>
                                            <span class="text-2xl font-black">12</span>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Dr. Ben Carter</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Nutritionist</p>
                                        </div>
                                        <div class="text-right">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                11:00 AM</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Virtual Consultation</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                    <p class="text-primary text-4xl font-black tracking-tight">$245.50</p>
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
                            <!-- Doctor on Call -->
                            <div
                                class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                                <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                                    Your Care Team</h2>
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12"
                                            data-alt="Profile picture of Dr. Evelyn Reed"
                                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w");'>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Dr. Evelyn Reed</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Oncologist</p>
                                        </div>
                                        <button
                                            class="flex items-center justify-center rounded-full size-9 bg-primary/10 dark:bg-primary/20 text-primary">
                                            <span class="material-symbols-outlined text-xl">chat_bubble</span>
                                        </button>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-12"
                                            data-alt="Profile picture of Dr. Ben Carter"
                                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDAQUwLGdNs9hFBr7Crk63XUevh0oH0yu70j6uY6brdBiL6vmeMwyl36Cz1MGlLFwzec0gGNU-9ILfhdsAES5IqHY1mWfqMOcA7BdbNel_9lFjpNv-YRWq4BMf39S_BZwekMxylhHjfkNyL_haZmFEcc8iGck2biPs7jjk2GLwrfVO07jHkOqJY2vyJfQIfcNqvvEQPKNofVJDagnT3ZTbOpRaFhKa4C3TfdEFKMKVjE-dnhw-cFWlM4EURQc4gRmc3td5PGA6tpQ");'>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                Dr. Ben Carter</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                Nutritionist</p>
                                        </div>
                                        <button
                                            class="flex items-center justify-center rounded-full size-9 bg-primary/10 dark:bg-primary/20 text-primary">
                                            <span class="material-symbols-outlined text-xl">chat_bubble</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>