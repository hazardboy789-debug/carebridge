<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    My Profile
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Update your specialization, schedule, and contact information.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2" wire:click="saveProfile">
                <span class="material-symbols-outlined">save</span>
                <span class="truncate">Save Changes</span>
            </button>
        </div>

        <!-- Profile Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Personal Information -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Personal Information
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Full Name
                            </label>
                            <input type="text" wire:model="name" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Email Address
                            </label>
                            <input type="email" wire:model="email" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Phone Number
                            </label>
                            <input type="tel" wire:model="phone" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Specialization
                            </label>
                            <select wire:model="specialization" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="">Select Specialization</option>
                                <option value="cardiology">Cardiology</option>
                                <option value="oncology">Oncology</option>
                                <option value="neurology">Neurology</option>
                                <option value="pediatrics">Pediatrics</option>
                                <option value="dermatology">Dermatology</option>
                                <option value="psychiatry">Psychiatry</option>
                                <option value="surgery">Surgery</option>
                                <option value="internal_medicine">Internal Medicine</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Qualifications
                            </label>
                            <input type="text" wire:model="qualification" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary" placeholder="MD, MBBS, etc.">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Bio
                            </label>
                            <textarea wire:model="bio" rows="4" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none" placeholder="Tell patients about your experience and expertise..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Schedule Settings -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                        Schedule & Availability
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Consultation Fee
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">$</span>
                                <input type="number" wire:model="consultationFee" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-8 pr-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Appointment Duration
                            </label>
                            <select wire:model="appointmentDuration" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="15">15 minutes</option>
                                <option value="30">30 minutes</option>
                                <option value="45">45 minutes</option>
                                <option value="60">60 minutes</option>
                            </select>
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-3">
                                Working Days
                            </label>
                            <div class="flex flex-wrap gap-3">
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" wire:model="workingDays" value="{{ $day }}" class="rounded text-primary focus:ring-primary">
                                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm capitalize">{{ $day }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                Start Time
                            </label>
                            <input type="time" wire:model="startTime" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                        
                        <div>
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">
                                End Time
                            </label>
                            <input type="time" wire:model="endTime" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Profile Photo -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Profile Photo
                    </h2>
                    <div class="flex flex-col items-center gap-4">
                        <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-32" style='background-image: url("{{ $avatar ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuAPyLJw3e-STCG-Z_O80E32_v6PZpysy71S1oSZahWCaDPPQmvcgI2t0gUj2Zrs9mZc37Qkvjq-vINlPqEmVzUN_TA36pmlmevEoz2tgIGY5cI3MriGJn0lQxDKPb_26F2nPz6-be5413GVSx6e1MTVRDeDgpC9AXz4sPxw53iRSaKl4L-kNXkJUbxSJl3uRQ0yHwUqig5sZkkhDpfh1pOixCpqMsnux06f4TcFD80t8P87irVbR-BWMQobLI6VPC5xNX2hdY2Z0w' }}");'></div>
                        <div class="flex gap-2">
                            <button class="flex items-center justify-center gap-1 rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                <span class="material-symbols-outlined text-sm">upload</span>
                                Upload New
                            </button>
                            <button class="flex items-center justify-center gap-1 rounded-lg h-9 px-4 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-medium hover:bg-gray-50 dark:hover:bg-slate-700">
                                <span class="material-symbols-outlined text-sm">delete</span>
                                Remove
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Account Status
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Profile Completion</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $profileCompletion }}%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Verification</span>
                            <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">Verified</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Member Since</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ auth()->user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Practice Stats
                    </h2>
                    <div class="flex flex-col gap-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Patients</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $totalPatients }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Appointments</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $totalAppointments }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Satisfaction Rate</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $satisfactionRate }}/5</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>