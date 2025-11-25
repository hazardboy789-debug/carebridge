<div class="flex-1 p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Appointments
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Manage your appointment schedule and patient consultations.
                </p>
            </div>
            <button class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
                <span class="material-symbols-outlined">add</span>
                <span class="truncate">Set Availability</span>
            </button>
        </div>

        <!-- Appointments Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Column -->
            <div class="lg:col-span-3 flex flex-col gap-8">
                <!-- Appointments Tabs -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex gap-4">
                            <button wire:click="setFilter('today')" class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'today' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary' }}">
                                Today
                            </button>
                            <button wire:click="setFilter('upcoming')" class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'upcoming' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary' }}">
                                Upcoming
                            </button>
                            <button wire:click="setFilter('pending')" class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'pending' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary' }}">
                                Pending
                            </button>
                            <button wire:click="setFilter('all')" class="px-4 py-2 rounded-lg text-sm font-medium {{ $filter === 'all' ? 'bg-primary text-white' : 'bg-background-light dark:bg-background-dark text-text-light-primary dark:text-text-dark-primary' }}">
                                All
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <input type="text" wire:model.debounce.300ms="search" placeholder="Search appointments..." class="bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg pl-10 pr-4 py-2 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary w-64">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 transform -translate-y-1/2 text-text-light-secondary dark:text-text-dark-secondary">search</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-border-light dark:border-border-dark">
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Patient</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Date & Time</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Type</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Status</th>
                                    <th class="text-left py-3 px-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-light dark:divide-border-dark">
                                @forelse($appointments as $appointment)
                                <tr class="hover:bg-background-light dark:hover:bg-background-dark">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="bg-center bg-no-repeat aspect-square bg-cover rounded-full size-10" style='background-image: url("{{ $appointment->patient->avatar ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuBmoJ7zWljb-6oG8m3ruqHc_HJBrlj0SL-YJrRySRqzdiEOLUaC4dCutjq-IATLBJ9HMmYNf6wX0XVbROieBzLVfjzSdSqaXKckizUENhpVyCypmVQUW0n8qlyonn-6WFZ9tlfdZUcG8_apNL-YoCv5zsAIynHVuEwEdKaqpF_NkIePpngu2hMYNT7waE7Ws2B6J9kJxzmcYAicG_trQe760nCkKe6aJ8ZxBPc_6M_6D1J723zypAp2MjZW60fwqZoC_t-dxgyb0A' }}");'></div>
                                            <div>
                                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                                    {{ $appointment->patient->name ?? 'Patient' }}
                                                </p>
                                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                    {{ $appointment->reason }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <p class="text-text-light-primary dark:text-text-dark-primary text-sm">{{ $appointment->scheduled_at->format('M d, Y') }}</p>
                                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">{{ $appointment->scheduled_at->format('h:i A') }}</p>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($appointment->type) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="bg-{{ $appointment->status === 'confirmed' ? 'green' : ($appointment->status === 'pending' ? 'yellow' : 'red') }}-100 dark:bg-{{ $appointment->status === 'confirmed' ? 'green' : ($appointment->status === 'pending' ? 'yellow' : 'red') }}-900/20 text-{{ $appointment->status === 'confirmed' ? 'green' : ($appointment->status === 'pending' ? 'yellow' : 'red') }}-800 dark:text-{{ $appointment->status === 'confirmed' ? 'green' : ($appointment->status === 'pending' ? 'yellow' : 'red') }}-300 text-xs px-2 py-1 rounded-full">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            @if($appointment->status === 'pending')
                                            <button wire:click="acceptAppointment({{ $appointment->id }})" class="flex items-center justify-center rounded-lg h-8 px-3 bg-green-600 text-white text-xs font-medium">
                                                Accept
                                            </button>
                                            <button wire:click="rejectAppointment({{ $appointment->id }})" class="flex items-center justify-center rounded-lg h-8 px-3 bg-red-600 text-white text-xs font-medium">
                                                Reject
                                            </button>
                                            @elseif($appointment->status === 'confirmed')
                                            <button wire:click="startAppointment({{ $appointment->id }})" class="flex items-center justify-center rounded-lg h-8 px-3 bg-primary text-white text-xs font-medium">
                                                Start
                                            </button>
                                            @endif
                                            <button wire:click="viewPatient({{ $appointment->patient_id }})" class="flex items-center justify-center rounded-full size-8 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                                <span class="material-symbols-outlined text-lg">visibility</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-text-light-secondary dark:text-text-dark-secondary">
                                        <span class="material-symbols-outlined text-4xl mb-2">calendar_today</span>
                                        <p>No appointments found</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-6">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="lg:col-span-1 flex flex-col gap-8">
                <!-- Appointment Stats -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Appointment Stats
                    </h2>
                    <div class="flex flex-col gap-4">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Today</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $appointmentStats['today'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">This Week</span>
                            <span class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $appointmentStats['week'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Pending</span>
                            <span class="text-yellow-600 dark:text-yellow-400 font-bold">{{ $appointmentStats['pending'] }}</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-background-light dark:bg-background-dark">
                            <span class="text-text-light-primary dark:text-text-dark-primary text-sm">Completed</span>
                            <span class="text-green-600 dark:text-green-400 font-bold">{{ $appointmentStats['completed'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Calendar Widget -->
                <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                        Schedule Calendar
                    </h2>
                    <div class="bg-background-light dark:bg-background-dark p-4 rounded-lg">
                        <!-- Simple calendar view - you can integrate a full calendar component here -->
                        <div class="text-center text-text-light-secondary dark:text-text-dark-secondary text-sm mb-3">
                            {{ now()->format('F Y') }}
                        </div>
                        <div class="grid grid-cols-7 gap-1 text-xs text-center">
                            @foreach(['S', 'M', 'T', 'W', 'T', 'F', 'S'] as $day)
                            <div class="font-medium text-text-light-secondary dark:text-text-dark-secondary py-1">{{ $day }}</div>
                            @endforeach
                            <!-- Calendar days would go here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>