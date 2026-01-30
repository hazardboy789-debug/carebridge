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
                            <option value="All">All Appointments</option>
                            <option value="Today">Today</option>
                            <option value="This Week">This Week</option>
                            <option value="This Month">This Month</option>
                            <option value="Custom Range">Custom Range</option>
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
                            <option value="">All Status</option>
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
                            <option value="">All Types</option>
                            <option value="in-person">In-person</option>
                            <option value="virtual">Virtual</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    @if($hasActiveFilters)
                        <button wire:click="searchAppointments" type="button" class="flex items-center justify-center rounded-lg h-12 px-4 bg-primary hover:bg-primary/90 text-white text-sm font-bold gap-2 transition-all">
                            <span class="material-symbols-outlined">search</span>
                            Search
                        </button>
                        <button wire:click="resetFilters" type="button" class="flex items-center justify-center rounded-lg h-12 px-4 bg-gray-100 hover:bg-gray-200 text-sm font-medium gap-2 transition-all">
                            <span class="material-symbols-outlined">close</span>
                            Clear
                        </button>
                    @else
                        <button wire:click="searchAppointments" type="button" class="flex items-center justify-center rounded-lg h-12 px-4 bg-primary hover:bg-primary/90 text-white text-sm font-bold gap-2 transition-all">
                            <span class="material-symbols-outlined">search</span>
                            Search
                        </button>
                    @endif
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
                    {{-- Top search input removed per request --}}
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
                        @forelse($appointments as $ap)
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
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ optional(optional($ap->doctor)->doctorDetail)->specialization ?? '' }}</p>
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
                                @php
                                        if (isset($ap->type)) {
                                            $typeLabel = $ap->type ? ucfirst($ap->type) : 'In-person';
                                        } elseif (isset($ap->appointment_time)) {
                                            $typeLabel = $ap->appointment_time === 'virtual' ? 'Virtual' : 'In-person';
                                        } else {
                                            $typeLabel = 'In-person';
                                        }

                                        $typeColor = $typeLabel === 'Virtual'
                                            ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300'
                                            : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                    @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $typeColor }}">
                                    <span class="material-symbols-outlined text-xs mr-1">
                                        {{ $typeLabel === 'Virtual' ? 'videocam' : 'person' }}
                                    </span>
                                    {{ $typeLabel }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    $status = strtolower($ap->status ?? '');
                                    switch ($status) {
                                        case 'confirmed':
                                        case 'completed':
                                            $statusColor = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300';
                                            $statusIcon = 'check_circle';
                                            break;
                                        case 'scheduled':
                                            $statusColor = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
                                            $statusIcon = 'event';
                                            break;
                                        case 'pending':
                                            $statusColor = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300';
                                            $statusIcon = 'pending';
                                            break;
                                        case 'cancelled':
                                            $statusColor = 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                                            $statusIcon = 'close';
                                            break;
                                        default:
                                            $statusColor = 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300';
                                            $statusIcon = 'help';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                    <span class="material-symbols-outlined text-xs mr-1">{{ $statusIcon }}</span>
                                    {{ ucfirst($ap->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2">
                                    <button 
                                            class="flex items-center justify-center rounded-lg h-9 w-9 bg-blue-100 dark:bg-blue-900 hover:bg-blue-200 dark:hover:bg-blue-800 text-blue-600 dark:text-blue-300 transition-all"
                                            title="View Details">
                                        <span class="material-symbols-outlined text-sm">visibility</span>
                                    </button>
                                    <button class="flex items-center justify-center rounded-lg h-9 w-9 bg-yellow-100 dark:bg-yellow-900 hover:bg-yellow-200 dark:hover:bg-yellow-800 text-yellow-600 dark:text-yellow-300 transition-all" title="Edit Appointment">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>
                                    <button onclick="return confirm('Are you sure you want to cancel this appointment?')" class="flex items-center justify-center rounded-lg h-9 w-9 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-600 dark:text-red-300 transition-all" title="Cancel Appointment">
                                        <span class="material-symbols-outlined text-sm">close</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-6 text-center">
                                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                                    <span class="material-symbols-outlined text-gray-400 dark:text-gray-500 text-4xl">event_busy</span>
                                </div>
                                <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-semibold mb-2">
                                    No appointments found
                                </h3>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary">
                                    @if($search || $status || $doctor || $type || $dateRange !== 'All')
                                        Try changing your filters or search terms.
                                    @else
                                        No appointments have been scheduled yet.
                                    @endif
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Table Footer -->
            @if($appointments->hasPages())
                <div class="px-6 py-4 bg-background-light dark:bg-background-dark border-t border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between">
                        <div class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                            Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} appointments
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $appointments->links() }}
                        </div>
                    </div>
                </div>
            @endif
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
                        <div class="text-text-light-secondary dark:text-text-dark-secondary text-center py-4">
                            <span class="material-symbols-outlined text-4xl text-gray-400 dark:text-gray-500 mb-2">event_available</span>
                            <p>No appointments scheduled for today</p>
                        </div>
                    @else
                        @foreach($todayAppointments as $t)
                            <div class="flex items-center gap-4 p-4 rounded-lg bg-background-light dark:bg-background-dark">
                                <div class="flex flex-col items-center justify-center {{ $this->getStatusColor($t->status) }} w-14 h-14 rounded-lg">
                                    <span class="text-xs font-bold">{{ optional($t->scheduled_at)->format('h:i') }}</span>
                                    <span class="text-xs">{{ optional($t->scheduled_at)->format('A') }}</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $t->patient->name ?? '—' }}</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $t->notes ?? '' }} • {{ $t->doctor->name ?? '' }}</p>
                                </div>
                                <span class="text-xs px-3 py-1 rounded-full {{ $this->getStatusColor($t->status) }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Quick Actions removed; actions available in filter bar -->
        </div>
    </div>
</div>

@push('scripts')
<script>
    // no-op: custom date inputs are controlled by Blade conditionals
</script>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:load', () => {
        // no-op listeners removed
    });
</script>
@endpush