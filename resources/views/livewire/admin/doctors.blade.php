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
                        Manage all doctor records and information.
                    </p>
                </div>
                <button wire:click="create" type="button" class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                    <span class="truncate">Add Doctor</span>
                </button>

                @if(session()->has('message'))
                    <div class="ml-4 px-4 py-2 rounded bg-green-50 text-green-800 text-sm">{{ session('message') }}</div>
                @endif

                @if(session()->has('error'))
                    <div class="ml-4 px-4 py-2 rounded bg-red-50 text-red-800 text-sm">{{ session('error') }}</div>
                @endif

                @if($showCreateModal)
                <div class="fixed inset-0 z-50 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50" wire:click="closeCreateModal"></div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg w-full max-w-2xl p-6 z-10 max-h-[90vh] overflow-y-auto">
                        <h3 class="text-lg font-bold mb-4 text-text-light-primary dark:text-text-dark-primary">{{ $editing ? 'Edit Doctor' : 'Add Doctor' }}</h3>

                        @if(session()->has('message'))
                            <div class="mb-3 text-sm text-green-700">{{ session('message') }}</div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs">Name *</label>
                                <input type="text" wire:model.defer="name" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs">Email *</label>
                                <input type="email" wire:model.defer="email" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">Contact</label>
                                <input type="text" wire:model.defer="contact" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                @error('contact') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs">Password (optional)</label>
                                <input type="text" wire:model.defer="password" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white" placeholder="Leave blank to auto-generate">
                                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">Date of Birth</label>
                                <input type="date" wire:model.defer="dob" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                @error('dob') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-xs">Gender</label>
                                <select wire:model.defer="gender" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                @error('gender') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs">Address</label>
                                <input type="text" wire:model.defer="address" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                @error('address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">Specialization *</label>
                                <input type="text" wire:model.defer="specialization" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white" placeholder="e.g., Cardiology">
                                @error('specialization') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">License Number *</label>
                                <input type="text" wire:model.defer="license_number" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white" placeholder="e.g., MED123456">
                                @error('license_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">Experience (Years)</label>
                                <input type="number" wire:model.defer="experience_years" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white" placeholder="0">
                                @error('experience_years') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="text-xs">Status</label>
                                <select wire:model.defer="doctor_status" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white">
                                    <option value="pending">Pending</option>
                                    <option value="approved">Approved</option>
                                    <option value="rejected">Rejected</option>
                                </select>
                                @error('doctor_status') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs">Description</label>
                                <textarea wire:model.defer="description" rows="3" class="mt-1 w-full rounded border px-3 py-2 dark:bg-slate-700 dark:text-white" placeholder="Doctor description..."></textarea>
                                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-end gap-3">
                            <button type="button" wire:click="closeCreateModal" class="px-4 py-2 rounded bg-gray-200 dark:bg-slate-600 dark:text-white">Cancel</button>
                            @if($editing)
                                <button type="button" wire:click="updateDoctor" class="px-4 py-2 rounded bg-primary text-white">Update Doctor</button>
                            @else
                                <button type="button" wire:click="createDoctor" class="px-4 py-2 rounded bg-primary text-white">Save Doctor</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                
                @if($viewModal)
                <div class="fixed inset-0 z-40 flex items-center justify-center">
                    <div class="absolute inset-0 bg-black/50" wire:click="closeViewModal"></div>
                    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-lg w-full max-w-lg p-6 z-10">
                        <h3 class="text-lg font-bold mb-2 text-text-light-primary dark:text-text-dark-primary">Doctor Details</h3>
                        @if($viewingDoctor)
                            <div class="space-y-2 text-sm">
                                <div><strong>Name:</strong> {{ $viewingDoctor->name }}</div>
                                <div><strong>Email:</strong> {{ $viewingDoctor->email }}</div>
                                <div><strong>Contact:</strong> {{ $viewingDoctor->contact ?? 'Not provided' }}</div>
                                <div><strong>Specialization:</strong> {{ $viewingDoctor->doctorDetail->specialization ?? 'N/A' }}</div>
                                <div><strong>License Number:</strong> {{ $viewingDoctor->doctorDetail->license_number ?? 'N/A' }}</div>
                                <div><strong>Experience:</strong> {{ $viewingDoctor->doctorDetail->experience_years ?? '0' }} years</div>
                                <div><strong>Status:</strong> {{ ucfirst($viewingDoctor->doctorDetail->status ?? 'pending') }}</div>
                                <div><strong>Registered:</strong> {{ $viewingDoctor->created_at->format('M d, Y') }}</div>
                                <div><strong>DOB:</strong> {{ optional($viewingDoctor->doctorDetail)->dob ?? 'N/A' }}</div>
                                <div><strong>Gender:</strong> {{ optional($viewingDoctor->doctorDetail)->gender ?? 'N/A' }}</div>
                                <div><strong>Address:</strong> {{ optional($viewingDoctor->doctorDetail)->address ?? 'N/A' }}</div>
                                @if($viewingDoctor->doctorDetail->description)
                                    <div><strong>Description:</strong> {{ $viewingDoctor->doctorDetail->description }}</div>
                                @endif
                            </div>
                        @endif
                        <div class="mt-4 flex justify-end">
                            <button type="button" wire:click="closeViewModal" class="px-4 py-2 rounded bg-gray-200 dark:bg-slate-600 dark:text-white">Close</button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Doctors Content -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-3 flex flex-col gap-8">
                    <!-- Doctors Table -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <div class="flex items-center justify-between mb-6">
                            <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                                All Doctors
                            </h2>
                            <div class="flex items-center gap-3">
                                <div class="relative">
                                    <input wire:model.debounce.300ms="search" type="text" placeholder="Search doctors..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
                                    <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                                </div>
                                <select wire:model="status" class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b border-border-light dark:border-border-dark">
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Doctor</th>
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Contact</th>
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Specialization</th>
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">License</th>
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                        <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                    @forelse($doctors as $doctor)
                                    <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-3">
                                                <div class="flex items-center justify-center rounded-full size-10 bg-primary/10 dark:bg-primary/20 text-primary">
                                                    <span class="material-symbols-outlined">medical_services</span>
                                                </div>
                                                <div>
                                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                        {{ $doctor->name }}
                                                    </p>
                                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                        {{ $doctor->doctorDetail->experience_years ?? 0 }} years exp.
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $doctor->email }}</p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $doctor->contact ?? 'Not provided' }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $doctor->doctorDetail->specialization ?? 'Not specified' }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $doctor->doctorDetail->license_number ?? 'Not provided' }}</p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 rounded-full text-xs {{ $doctor->is_active ? 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-300' }}">
                                                {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs mt-1">
                                                {{ ucfirst($doctor->doctorDetail->status ?? 'pending') }}
                                            </p>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2">
                                                <button wire:click="viewDoctor({{ $doctor->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary" title="View">
                                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                                </button>
                                                <button wire:click="edit({{ $doctor->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary" title="Edit">
                                                    <span class="material-symbols-outlined text-lg">edit</span>
                                                </button>
                                                <button wire:click="toggleStatus({{ $doctor->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 text-yellow-500" title="Toggle Status">
                                                    <span class="material-symbols-outlined text-lg">swap_horiz</span>
                                                </button>
                                                <button onclick="confirm('Are you sure you want to delete this doctor?') || event.stopImmediatePropagation()" wire:click="deleteDoctor({{ $doctor->id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500" title="Delete">
                                                    <span class="material-symbols-outlined text-lg">delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="py-4 px-4 text-center text-text-light-secondary dark:text-text-dark-secondary">
                                            No doctors found.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            {{ $doctors->links() }}
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="lg:col-span-1 flex flex-col gap-8">
                    <!-- Quick Stats -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                            Doctor Stats
                        </h2>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Total Doctors</span>
                                <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $doctors->total() }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Active</span>
                                <span class="text-green-600 dark:text-green-400 font-bold">
                                    {{ $doctors->where('is_active', true)->count() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Pending</span>
                                <span class="text-yellow-600 dark:text-yellow-400 font-bold">
                                    {{ $doctors->filter(function($doctor) { 
                                        return optional($doctor->doctorDetail)->status === 'pending'; 
                                    })->count() }}
                                </span>
                            </div>
                            <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Approved</span>
                                <span class="text-blue-600 dark:text-blue-400 font-bold">
                                    {{ $doctors->filter(function($doctor) { 
                                        return optional($doctor->doctorDetail)->status === 'approved'; 
                                    })->count() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>