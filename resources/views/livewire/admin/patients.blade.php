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
            <button wire:click="openCreateModal" type="button" class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="truncate">Add Patient</span>
            </button>

            @if(session()->has('message'))
                <div class="ml-4 px-4 py-2 rounded bg-green-50 text-green-800 text-sm">{{ session('message') }}</div>
            @endif

            @if($showCreateModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50" wire:click="closeCreateModal"></div>
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg w-full max-w-2xl p-6 z-10">
                    <h3 class="text-lg font-bold mb-4 text-text-light-primary dark:text-text-dark-primary">{{ $editing ? 'Edit Patient' : 'Add Patient' }}</h3>

                    @if(session()->has('message'))
                        <div class="mb-3 text-sm text-green-700">{{ session('message') }}</div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs">Name</label>
                            <input type="text" wire:model.defer="name" class="mt-1 w-full rounded border px-3 py-2">
                            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs">Email</label>
                            <input type="email" wire:model.defer="email" class="mt-1 w-full rounded border px-3 py-2">
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-xs">Contact</label>
                            <input type="text" wire:model.defer="contact" class="mt-1 w-full rounded border px-3 py-2">
                            @error('contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs">Password (optional)</label>
                            <input type="text" wire:model.defer="password" class="mt-1 w-full rounded border px-3 py-2" placeholder="Leave blank to auto-generate">
                            @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-xs">Date of Birth</label>
                            <input type="date" wire:model.defer="dob" class="mt-1 w-full rounded border px-3 py-2">
                            @error('dob') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs">Age</label>
                            <input type="number" wire:model.defer="age" class="mt-1 w-full rounded border px-3 py-2">
                            @error('age') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="text-xs">Address</label>
                            <input type="text" wire:model.defer="address" class="mt-1 w-full rounded border px-3 py-2">
                            @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-xs">Gender</label>
                            <select wire:model.defer="gender" class="mt-1 w-full rounded border px-3 py-2">
                                <option value="">Select</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                            @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-xs">Status</label>
                            <select wire:model.defer="patient_status" class="mt-1 w-full rounded border px-3 py-2">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('patient_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4 flex items-center justify-end gap-3">
                        <button type="button" wire:click="closeCreateModal" class="px-4 py-2 rounded bg-gray-200">Cancel</button>
                        @if($editing)
                            <button type="button" wire:click="updatePatient" class="px-4 py-2 rounded bg-primary text-white">Update Patient</button>
                        @else
                            <button type="button" wire:click="createPatient" class="px-4 py-2 rounded bg-primary text-white">Save Patient</button>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            
            @if($viewModal)
            <div class="fixed inset-0 z-40 flex items-center justify-center">
                <div class="absolute inset-0 bg-black/50" wire:click="closeViewModal"></div>
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg w-full max-w-lg p-6 z-10">
                    <h3 class="text-lg font-bold mb-2">Patient Details</h3>
                    @if($viewingPatient)
                        <div class="space-y-2 text-sm">
                            <div><strong>Name:</strong> {{ $viewingPatient->name }}</div>
                            <div><strong>Email:</strong> {{ $viewingPatient->email }}</div>
                            <div><strong>Contact:</strong> {{ $viewingPatient->contact ?? 'Not provided' }}</div>
                            <div><strong>Registered:</strong> {{ $viewingPatient->created_at->format('M d, Y') }}</div>
                            <div><strong>DOB:</strong> {{ optional($viewingPatient->userDetails)->dob ?? 'N/A' }}</div>
                            <div><strong>Age:</strong> {{ optional($viewingPatient->userDetails)->age ?? 'N/A' }}</div>
                            <div><strong>Address:</strong> {{ optional($viewingPatient->userDetails)->address ?? 'N/A' }}</div>
                            <div><strong>Gender:</strong> {{ optional($viewingPatient->userDetails)->gender ?? 'N/A' }}</div>
                        </div>
                    @endif
                    <div class="mt-4 flex justify-end">
                        <button type="button" wire:click="closeViewModal" class="px-4 py-2 rounded bg-gray-200">Close</button>
                    </div>
                </div>
            </div>
            @endif
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
                                @foreach($patients as $patient)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="flex items-center justify-center rounded-full size-10 bg-primary/10 dark:bg-primary/20 text-primary">
                                                <span class="material-symbols-outlined">person</span>
                                            </div>
                                            <div>
                                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                    {{ $patient->name }}
                                                </p>
                                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                    ID: {{ $patient->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $patient->email }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $patient->contact ?? 'Not provided' }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-2 py-1 rounded-full">
                                            {{ $patient->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $patient->created_at->format('M d, Y') }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Registered</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <button wire:click="viewPatient({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary" title="View">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                            <button wire:click="openEditModal({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary" title="Edit">
                                                <span class="material-symbols-outlined text-lg">edit</span>
                                            </button>
                                            <button onclick="confirm('Are you sure you want to delete this patient?') || event.stopImmediatePropagation()" wire:click="deletePatient({{ $patient->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500" title="Delete">
                                                <span class="material-symbols-outlined text-lg">delete</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="flex flex-col gap-4">
                <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Patients</span>
                    <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $stats['total'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm">New This Month</span>
                    <span class="text-green-600 dark:text-green-400 font-bold">+{{ $stats['newThisMonth'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Active Today</span>
                    <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $stats['activeToday'] }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                    <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Appointments</span>
                    <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $stats['appointments'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
