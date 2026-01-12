<div class="p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Header -->
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                Appointments Management
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Manage and monitor all patient appointments
            </p>
        </div>

        {{-- Data is provided by the Livewire component: $appointments, $todayStats, $todayAppointments --}}

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Appointments -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900">
                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300">event</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Total Appointments</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $appointments->total() }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">trending_up</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">+12% from yesterday</span>
                </div>
            </div>

            <!-- Today's Appointments -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900">
                        <span class="material-symbols-outlined text-green-500 dark:text-green-300">today</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Today's Appointments</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $todayStats['total'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-green-500">check_circle</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">All confirmed</span>
                </div>
            </div>

            <!-- Pending Appointments -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-orange-100 dark:bg-orange-900">
                        <span class="material-symbols-outlined text-orange-500 dark:text-orange-300">pending</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Pending Confirmation</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $todayStats['upcoming'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-yellow-500">warning</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Require attention</span>
                </div>
            </div>

            <!-- Cancelled Appointments -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900">
                        <span class="material-symbols-outlined text-red-500 dark:text-red-300">close</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Cancelled</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $todayStats['cancelled'] ?? 0 }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm text-red-500">arrow_downward</span>
                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">-2 from last week</span>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                <!-- Filter Section -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Date Filter -->
                    <div>
                        <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                            Date Range
                        </label>
                        <select wire:model="dateRange" class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>Today</option>
                            <option>This Week</option>
                            <option>This Month</option>
                            <option>All</option>
                            <option>Custom Range</option>
                        </select>

                        @if($dateRange === 'Custom Range')
                            <div class="mt-2 flex gap-2">
                                <input wire:model="startDate" type="date" class="w-1/2 border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary" />
                                <input wire:model="endDate" type="date" class="w-1/2 border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-3 py-2 text-text-light-primary dark:text-text-dark-primary" />
                            </div>
                        @endif
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                            Status
                        </label>
                        <select wire:model="status" class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>All Status</option>
                            <option value="scheduled">Scheduled</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="pending">Pending</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>

                    <!-- Doctor Filter -->
                    <div>
                        <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                            Doctor
                        </label>
                        <select wire:model="doctor" class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">All Doctors</option>
                            @foreach($doctors as $d)
                                <option value="{{ $d->id }}">{{ $d->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type Filter -->
                    <div>
                        <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                            Appointment Type
                        </label>
                        <select wire:model="type" class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option>All Types</option>
                            <option>In-person</option>
                            <option>Virtual</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-primary hover:bg-primary/90 text-white text-sm font-bold gap-2 transition-all">
                        <span class="material-symbols-outlined">add</span>
                        New Appointment
                    </button>
                    
                    <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-green-500 hover:bg-green-600 text-white text-sm font-bold gap-2 transition-all">
                        <span class="material-symbols-outlined">sync</span>
                        Reschedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Appointments Table -->
        <div class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark overflow-hidden">
            <!-- Table Header -->
            <div class="px-6 py-4 bg-background-light dark:bg-background-dark border-b border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between">
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        All Appointments
                    </h3>
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <input wire:model.debounce.500ms="search" type="text" placeholder="Search appointments..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent w-64">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-border-light dark:border-border-dark">
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Patient</th>
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Doctor</th>
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Date & Time</th>
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Type</th>
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Status</th>
                            <th class="text-left py-4 px-6 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-light dark:divide-border-dark">
                        @foreach($appointments as $ap)
                        <tr class="hover:bg-background-light dark:hover:bg-background-dark transition-colors duration-200">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900">
                                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300">person</span>
                                    </div>
                                    <div>
                                        <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $ap->patient->name ?? '—' }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $ap->notes ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-green-100 dark:bg-green-900">
                                        <span class="material-symbols-outlined text-green-500 dark:text-green-300 text-sm">medical_services</span>
                                    </div>
                                    <div>
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $ap->doctor->name ?? '—' }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ optional(optional($ap->doctor)->doctorDetail)->specialty ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ optional($ap->scheduled_at)->format('M d, Y') }}</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ optional($ap->scheduled_at)->format('h:i A') }}{{ $ap->duration ? ' • '.$ap->duration : '' }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300">
                                    <span class="material-symbols-outlined text-xs mr-1">person</span>
                                    {{ ucfirst($ap->appointment_time ? 'Virtual' : 'In-person') }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ strtolower($ap->status) === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    <span class="material-symbols-outlined text-xs mr-1">{{ strtolower($ap->status) === 'confirmed' ? 'check_circle' : 'pending' }}</span>
                                    {{ ucfirst($ap->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <button class="flex items-center justify-center rounded-lg h-9 w-9 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-600 dark:text-blue-300 transition-all">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </button>
                                    <button class="flex items-center justify-center rounded-lg h-9 w-9 bg-yellow-100 dark:bg-yellow-900 hover:bg-yellow-200 dark:hover:bg-yellow-800 text-yellow-600 dark:text-yellow-300 transition-all">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>
                                    <button class="flex items-center justify-center rounded-lg h-9 w-9 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-600 dark:text-red-300 transition-all">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            <div class="px-6 py-4 bg-background-light dark:bg-background-dark border-t border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between">
                    <div class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        Showing 1 to {{ $appointments->count() }} of {{ $appointments->total() }} appointments
                    </div>
                    <div class="flex items-center gap-2">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Today's Schedule -->
            <div class="lg:col-span-2 bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        Today's Schedule
                    </h3>
                    <a href="#" class="text-primary text-sm font-bold hover:underline">View Full Schedule</a>
                </div>
                
                <div class="space-y-4">
                    @if($todayAppointments->isEmpty())
                        <div class="text-text-light-secondary dark:text-text-dark-secondary">No appointments scheduled for today.</div>
                    @else
                        @foreach($todayAppointments as $t)
                            <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                <div class="flex flex-col items-center justify-center bg-blue-500 text-white w-14 h-14 rounded-lg">
                                    <span class="text-xs font-bold">{{ optional($t->scheduled_at)->format('h:i') }}</span>
                                    <span class="text-xs">{{ optional($t->scheduled_at)->format('A') }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $t->patient->name ?? '—' }}</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $t->notes ?? '' }} • {{ $t->doctor->name ?? '' }}</p>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ strtolower($t->status) === 'confirmed' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Quick Actions removed -->
        </div>
    </div>
</div>