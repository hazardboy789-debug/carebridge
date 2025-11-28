<div>
    <!-- Success/Error Messages -->
    @if(session('message'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <p class="text-green-800 dark:text-green-300 text-sm">{{ session('message') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
            <p class="text-red-800 dark:text-red-300 text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                Doctor Appointments
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Manage and approve patient appointments.
            </p>
        </div>
    </div>

    <!-- Pending Appointments (Need Approval) -->
    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                Pending Approval
            </h2>
            <span class="bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 text-xs px-3 py-1 rounded-full">
                {{ count($pendingAppointments) }} pending
            </span>
        </div>
        
        <div class="space-y-4">
            @if(count($pendingAppointments) > 0)
                @foreach($pendingAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-center justify-center bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-300 w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('M') }}</span>
                                <span class="text-2xl font-black">{{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    {{ $appointment['patient']['name'] ?? 'Patient' }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-2">
                                    <span class="material-symbols-outlined text-sm mr-1">calendar_month</span>
                                    {{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('M d, Y • h:i A') }}
                                </p>
                                @if($appointment['symptoms'])
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        <strong>Symptoms:</strong> {{ \Illuminate\Support\Str::limit($appointment['symptoms'], 100) }}
                                    </p>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <button wire:click="viewAppointment({{ $appointment['id'] }})" 
                                    class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary text-white text-sm font-medium">
                                <span class="material-symbols-outlined text-sm mr-1">visibility</span>
                                View
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-text-light-secondary dark:text-text-dark-secondary">
                    <span class="material-symbols-outlined text-4xl mb-2">check_circle</span>
                    <p>No pending appointments</p>
                    <p class="text-sm mt-1">All appointments have been processed</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Upcoming Confirmed Appointments -->
    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                Upcoming Appointments
            </h2>
            <span class="bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 text-xs px-3 py-1 rounded-full">
                {{ count($upcomingAppointments) }} confirmed
            </span>
        </div>
        
        <div class="space-y-4">
            @if(count($upcomingAppointments) > 0)
                @foreach($upcomingAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-center justify-center bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300 w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('M') }}</span>
                                <span class="text-2xl font-black">{{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    {{ $appointment['patient']['name'] ?? 'Patient' }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                    {{ \Carbon\Carbon::parse($appointment['scheduled_at'])->format('M d, Y • h:i A') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-text-light-secondary dark:text-text-dark-secondary">
                    <span class="material-symbols-outlined text-4xl mb-2">schedule</span>
                    <p>No upcoming appointments</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Appointment Modal -->
    @if($showAppointmentModal && $selectedAppointment)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-full p-4">
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeModal"></div>
            
            <div class="relative bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark w-full max-w-2xl mx-auto">
                <div class="flex items-center justify-between p-6 border-b border-border-light dark:border-border-dark">
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        Appointment Details
                    </h3>
                    <button type="button" wire:click="closeModal" class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4 mb-6">
                        <div>
                            <strong>Patient:</strong> {{ $selectedAppointment->patient->name }}
                        </div>
                        <div>
                            <strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($selectedAppointment->scheduled_at)->format('M d, Y • h:i A') }}
                        </div>
                        <div>
                            <strong>Symptoms:</strong> {{ $selectedAppointment->symptoms }}
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Notes:</label>
                            <textarea wire:model="appointmentNotes" class="w-full border rounded-lg p-3" rows="3" placeholder="Add any notes..."></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 justify-end">
                        <button type="button" wire:click="rejectAppointment({{ $selectedAppointment->id }})" 
                                class="flex items-center justify-center rounded-lg h-11 px-6 bg-red-600 text-white text-sm font-bold gap-2">
                            <span class="material-symbols-outlined text-sm">close</span>
                            Reject
                        </button>
                        <button type="button" wire:click="approveAppointment({{ $selectedAppointment->id }})" 
                                class="flex items-center justify-center rounded-lg h-11 px-6 bg-green-600 text-white text-sm font-bold gap-2">
                            <span class="material-symbols-outlined text-sm">check</span>
                            Approve
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>