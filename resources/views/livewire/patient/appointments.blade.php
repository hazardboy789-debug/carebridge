<div>
    <!-- Success Message -->
    @if(session('booking_success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">check_circle</span>
                    <p class="text-green-800 dark:text-green-300 text-sm">{{ session('booking_success') }}</p>
                </div>
                <button type="button" class="text-green-600 dark:text-green-400 hover:text-green-800 dark:hover:text-green-200">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    @if(session('message'))
        <div class="mb-6 p-4 rounded-lg bg-blue-100 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
                    <p class="text-blue-800 dark:text-blue-300 text-sm">{{ session('message') }}</p>
                </div>
                <button type="button" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 dark:bg-red-900/20 border border-red-200 dark:border-red-800">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 dark:text-red-400">error</span>
                    <p class="text-red-800 dark:text-red-300 text-sm">{{ session('error') }}</p>
                </div>
                <button type="button" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-200">
                    <span class="material-symbols-outlined text-lg">close</span>
                </button>
            </div>
        </div>
    @endif

    <!-- Header -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                My Appointments
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Manage and track your medical appointments.
            </p>
        </div>
        <button wire:click="openBooking" class="flex min-w-[84px] items-center justify-center overflow-hidden rounded-lg h-12 px-5 bg-primary text-white text-sm font-bold gap-2">
            <span class="material-symbols-outlined">add</span>
            <span class="truncate">Book New Appointment</span>
        </button>
    </div>

    <!-- Upcoming Appointments -->
    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark mb-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                Upcoming Appointments
            </h2>
            <span class="bg-primary/10 dark:bg-primary/20 text-primary text-xs px-3 py-1 rounded-full">
                {{ count($upcomingAppointments) }} appointments
            </span>
        </div>
        
        <div class="space-y-4">
            @if(count($upcomingAppointments) > 0)
                @foreach($upcomingAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-center justify-center bg-primary/10 dark:bg-primary/20 text-primary w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M') }}</span>
                                <span class="text-2xl font-black">{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Dr. {{ $appointment['doctor']['name'] ?? 'N/A' }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-2">
                                    <span class="material-symbols-outlined text-sm mr-1">calendar_month</span>
                                    @php
                                        $datetime = null;
                                        // Prefer scheduled_at if present
                                        if (!empty($appointment['scheduled_at'])) {
                                            $datetime = $appointment['scheduled_at'];
                                        } else {
                                            $datePart = $appointment['appointment_date'] ?? null;
                                            $timePart = $appointment['appointment_time'] ?? null;

                                            // If datePart already contains time (ISO format), use it directly
                                            if ($datePart && strpos($datePart, 'T') !== false) {
                                                $datetime = $datePart;
                                            } else {
                                                // Normalize time to include seconds
                                                if ($timePart && preg_match('/^\d{2}:\d{2}$/', $timePart)) {
                                                    $timePart .= ':00';
                                                }
                                                $timePart = $timePart ?: '00:00:00';
                                                $datetime = trim(($datePart ?: '') . ' ' . $timePart);
                                            }
                                        }
                                    @endphp
                                    {{ \Carbon\Carbon::parse($datetime)->format('M d, Y • h:i A') }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="bg-{{ $appointment['status'] == 'confirmed' ? 'green' : ($appointment['status'] == 'pending' ? 'yellow' : 'red') }}-100 dark:bg-{{ $appointment['status'] == 'confirmed' ? 'green' : ($appointment['status'] == 'pending' ? 'yellow' : 'red') }}-900/20 text-{{ $appointment['status'] == 'confirmed' ? 'green' : ($appointment['status'] == 'pending' ? 'yellow' : 'red') }}-800 dark:text-{{ $appointment['status'] == 'confirmed' ? 'green' : ($appointment['status'] == 'pending' ? 'yellow' : 'red') }}-300 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst($appointment['status']) }}
                                    </span>
                                    @if($appointment['symptoms'])
                                        <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                            {{ \Illuminate\Support\Str::limit($appointment['symptoms'], 100) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            @if($appointment['status'] == 'pending')
                                <button wire:click="cancelAppointment({{ $appointment['id'] }})" 
                                        class="flex items-center justify-center rounded-lg h-9 px-4 bg-red-600 text-white text-sm font-medium"
                                        onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                    <span class="material-symbols-outlined text-sm mr-1">close</span>
                                    Cancel
                                </button>
                            @endif
                            <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-text-light-secondary dark:text-text-dark-secondary">
                    <span class="material-symbols-outlined text-4xl mb-2">calendar_today</span>
                    <p>No upcoming appointments found</p>
                    <p class="text-sm mt-1">Book your first appointment to get started</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Past Appointments -->
    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                Past Appointments
            </h2>
            <span class="bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs px-3 py-1 rounded-full">
                {{ count($pastAppointments) }} appointments
            </span>
        </div>
        
        <div class="space-y-4">
            @if(count($pastAppointments) > 0)
                @foreach($pastAppointments as $appointment)
                    <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                        <div class="flex items-center gap-4">
                            <div class="flex flex-col items-center justify-center bg-primary/10 dark:bg-primary/20 text-primary w-16 h-16 rounded-lg p-2">
                                <span class="text-sm font-bold">{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M') }}</span>
                                <span class="text-2xl font-black">{{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('d') }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                    Dr. {{ $appointment['doctor']['name'] ?? 'N/A' }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-2">
                                    <span class="material-symbols-outlined text-sm mr-1">calendar_month</span>
                                    {{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M d, Y') }} • {{ \Carbon\Carbon::parse($appointment['appointment_time'])->format('h:i A') }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <span class="bg-{{ $appointment['status'] == 'completed' ? 'green' : 'red' }}-100 dark:bg-{{ $appointment['status'] == 'completed' ? 'green' : 'red' }}-900/20 text-{{ $appointment['status'] == 'completed' ? 'green' : 'red' }}-800 dark:text-{{ $appointment['status'] == 'completed' ? 'green' : 'red' }}-300 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst($appointment['status']) }}
                                    </span>
                                    @if($appointment['symptoms'])
                                        <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                            {{ \Illuminate\Support\Str::limit($appointment['symptoms'], 100) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <button class="flex items-center justify-center rounded-full size-9 hover:bg-primary/10 dark:hover:bg-primary/20 text-text-light-secondary dark:text-text-dark-secondary">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </button>
                    </div>
                @endforeach
            @else
                <div class="text-center py-8 text-text-light-secondary dark:text-text-dark-secondary">
                    <span class="material-symbols-outlined text-4xl mb-2">history</span>
                    <p>No past appointments found</p>
                    <p class="text-sm mt-1">Your appointment history will appear here</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Booking Modal -->
    @if($showBookingModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-full p-4">
            
            <!-- UPDATED BACKDROP -->
            <div class="fixed inset-0 bg-black bg-opacity-50 transition-opacity" wire:click="closeBooking"></div>
            
            <div class="relative bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark w-full max-w-2xl mx-auto">
                <div class="flex items-center justify-between p-6 border-b border-border-light dark:border-border-dark">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">bookmark</span>
                        <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                            @if($selectedDoctor)
                                Book with Dr. {{ $selectedDoctor->name }}
                            @else
                                Book New Appointment
                            @endif
                        </h3>
                    </div>

                    <!-- UPDATED CLOSE BUTTON -->
                    <button type="button" wire:click="closeBooking" class="flex items-center justify-center rounded-full size-8 hover:bg-red-50 dark:hover:bg-red-900/20 text-red-500">
                        <span class="material-symbols-outlined text-lg">close</span>
                    </button>
                </div>
                
                <div class="p-6">
                    <form wire:submit.prevent="bookAppointment">
                        <!-- Doctor Selection -->
                        @if(!$selectedDoctor)
                        <div class="mb-6">
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-3">
                                Select Doctor *
                            </label>
                            <select wire:model="selectedDoctorId" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                <option value="">Choose a doctor...</option>
                                @foreach($doctors as $doctor)
                                        @php
                                            $docFee = $doctor->doctorDetail->consultation_fee ?? $doctor->consultation_fee ?? 0;
                                        @endphp
                                        <option value="{{ $doctor->id }}">
                                            Dr. {{ $doctor->name }} - {{ $doctor->doctorDetail->specialization ?? 'General Practitioner' }} @if($docFee > 0) - LKR {{ number_format($docFee, 2) }} @endif
                                        </option>
                                @endforeach
                            </select>
                            @error('selectedDoctorId') 
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                                <!-- Show booking fee for selected doctor -->
                                <input type="hidden" wire:model="fee">
                                @if($fee > 0)
                                <div class="mt-3">
                                    <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-1">Booking Fee</label>
                                    <div class="text-text-light-primary dark:text-text-dark-primary font-semibold">LKR {{ number_format($fee, 2) }}</div>
                                </div>
                                @endif
                        </div>
                        @else
                        <div class="mb-6 p-4 rounded-lg bg-primary/10 dark:bg-primary/20 border border-primary/20">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center rounded-full size-12 bg-primary/20 text-primary">
                                    <span class="material-symbols-outlined">stethoscope</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                        Dr. {{ $selectedDoctor->name }}
                                    </p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-2">
                                        {{ $selectedDoctor->doctorDetail->specialization ?? 'General Practitioner' }}
                                    </p>

                                    @if($fee > 0)
                                    <div class="mt-2 p-3 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                                        <div class="flex items-center justify-between">
                                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Doctor Fee</span>
                                            <span class="font-semibold">LKR {{ number_format($fee, 2) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-1">
                                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Platform Commission ({{ intval(($commissionPercent ?? 0.10) * 100) }}%)</span>
                                            <span class="text-sm">LKR {{ number_format(round($fee * ($commissionPercent ?? 0.10), 2), 2) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-text-light-primary dark:text-text-dark-primary font-medium">You will be charged</span>
                                            <span class="font-bold">LKR {{ number_format($fee, 2) }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                    <!-- Date Selection -->
<div class="mb-6">
    <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-3">
        Appointment Date *
    </label>
    <input type="date" wire:model="bookingDate" 
           class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary" 
           min="{{ now()->addDay()->format('Y-m-d') }}"
           max="{{ now()->addMonths(3)->format('Y-m-d') }}">
    @error('bookingDate') 
        <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
    @enderror
    @if($bookingDate && !$this->checkSlotAvailability())
        <div class="flex items-center gap-1 mt-2 text-red-600 dark:text-red-400 text-sm">
            <span class="material-symbols-outlined text-sm">warning</span>
            This date is not available with the selected doctor. Please choose another date.
        </div>
    @endif
</div>
                    <!-- Time Selection -->
                    <div class="mb-6">
                        <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-3">
                            Appointment Time *
                        </label>
                        <select wire:model="bookingTime" class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                            <option value="09:00">09:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="14:00">02:00 PM</option>
                            <option value="15:00">03:00 PM</option>
                            <option value="16:00">04:00 PM</option>
                            <option value="17:00">05:00 PM</option>
                        </select>
                        @error('bookingTime') 
                            <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                        <!-- Fee Breakdown -->
                        @if($fee > 0)
                        <div class="mb-6 p-4 rounded-lg bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark">
                            <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-2">Fee</p>
                            <div class="flex items-center justify-between">
                                <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Doctor Fee</span>
                                <span class="font-semibold">LKR {{ number_format($fee, 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-1">
                                <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Platform Commission ({{ intval(($commissionPercent ?? 0.10) * 100) }}%)</span>
                                <span class="text-sm">LKR {{ number_format(round($fee * ($commissionPercent ?? 0.10), 2), 2) }}</span>
                            </div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-text-light-primary dark:text-text-dark-primary font-medium">You will be charged</span>
                                <span class="font-bold">LKR {{ number_format($fee, 2) }}</span>
                            </div>

                            <div class="mt-3">
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Your Wallet Balance</p>
                                <div class="font-semibold">LKR {{ number_format($patientWalletBalance, 2) }}</div>
                                @if($patientWalletBalance < $fee)
                                    <div class="mt-2 text-red-600 dark:text-red-400 text-sm flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">warning</span>
                                        Insufficient wallet balance to pay the fee. Please top up your wallet.
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Reason -->
                        <div class="mb-6">
                            <label class="block text-text-light-primary dark:text-text-dark-primary text-sm font-medium mb-3">
                                Reason for Appointment *
                            </label>
                            <textarea wire:model="bookingReason" 
                                      class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none" 
                                      rows="4" 
                                      placeholder="Please describe your symptoms or reason for appointment..."></textarea>
                            @error('bookingReason') 
                                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex gap-3 justify-end">

                            <!-- UPDATED CANCEL BUTTON -->
                            <button type="button" wire:click="closeBooking" class="flex items-center justify-center rounded-lg h-11 px-6 bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark text-text-light-primary dark:text-text-dark-primary text-sm font-bold hover:bg-gray-50 dark:hover:bg-slate-700 gap-2">
                                <span class="material-symbols-outlined text-sm">close</span>
                                Cancel
                            </button>

                            @php $insufficient = ($fee > 0 && $patientWalletBalance < $fee); @endphp
                            <button type="submit"
                                    @if($insufficient) disabled @endif
                                    wire:loading.attr="disabled"
                                    class="flex items-center justify-center rounded-lg h-11 px-6 text-sm font-bold gap-2 {{ $insufficient ? 'bg-gray-300 text-gray-700 cursor-not-allowed' : 'bg-primary text-white' }}">
                                <span class="material-symbols-outlined text-sm">bookmark</span>
                                {{ $insufficient ? 'Insufficient Balance' : 'Book Appointment' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>