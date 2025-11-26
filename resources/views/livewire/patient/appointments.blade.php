<div>
    <div class="flex-1 p-8">
        <div class="flex flex-col gap-8">
            <!-- Page Heading -->
            <div class="flex flex-col gap-1">
                <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                    Book Appointment
                </p>
                <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                    Schedule your medical appointment with our specialist doctors.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Booking Form -->
                <div class="lg:col-span-2 flex flex-col gap-8">
                    <!-- Booking Form -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-6">
                            Book New Appointment
                        </h2>
                        
                        <form wire:submit.prevent="bookAppointment" class="flex flex-col gap-6">
                            <!-- Flash Messages -->
                            @if (session()->has('success'))
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <p class="text-green-700 dark:text-green-300 text-sm">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if (session()->has('error'))
                                <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                    <p class="text-red-700 dark:text-red-300 text-sm">{{ session('error') }}</p>
                                </div>
                            @endif

                            <!-- Select Doctor -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Select Doctor *
                                </label>
                                <select wire:model="selectedDoctorId" 
                                        class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="">Choose a doctor</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor['id'] }}">
                                        {{ $doctor['name'] }} - {{ $doctor['specialization'] }} ({{ $doctor['experience'] }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('selectedDoctorId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Appointment Date -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Appointment Date *
                                </label>
                                <input type="date" 
                                       wire:model="appointmentDate"
                                       min="{{ now()->addDay()->format('Y-m-d') }}"
                                       class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                @error('appointmentDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Appointment Time -->
                            @if($appointmentDate)
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Appointment Time *
                                </label>
                                <select wire:model="appointmentTime" 
                                        class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary">
                                    <option value="">Select time</option>
                                    @foreach($timeSlots as $time)
                                    <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                                @error('appointmentTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            @endif

                            <!-- Symptoms -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Symptoms Description *
                                </label>
                                <textarea rows="4" 
                                          wire:model="symptoms"
                                          placeholder="Describe your symptoms and concerns..."
                                          class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                                @error('symptoms') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Additional Notes -->
                            <div>
                                <label class="block text-text-light-primary dark:text-text-dark-primary font-medium mb-2">
                                    Additional Notes
                                </label>
                                <textarea rows="3" 
                                          wire:model="notes"
                                          placeholder="Any additional information for the doctor..."
                                          class="w-full bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-primary resize-none"></textarea>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit"
                                    class="flex w-full items-center justify-center gap-2 rounded-lg h-12 px-4 bg-primary text-white text-sm font-bold">
                                <span class="material-symbols-outlined">calendar_today</span>
                                Book Appointment
                            </button>
                        </form>
                    </div>

                    <!-- Upcoming Appointments -->
                    @if(count($upcomingAppointments) > 0)
                    <div>
    <h3>Upcoming Appointments</h3>
    @foreach($upcomingAppointments as $appointment)
        <div class="appointment-card">
            <p>Doctor: {{ $appointment['doctor']['name'] ?? 'N/A' }}</p>
            <p>Date: {{ $appointment['appointment_date'] }}</p>
            <p>Time: {{ $appointment['appointment_time'] }}</p>
            <p>Status: {{ $appointment['status'] }}</p>
        </div>
    @endforeach

    <h3>Past Appointments</h3>
    @foreach($pastAppointments as $appointment)
        <div class="appointment-card">
            <p>Doctor: {{ $appointment['doctor']['name'] ?? 'N/A' }}</p>
            <p>Date: {{ $appointment['appointment_date'] }}</p>
            <p>Time: {{ $appointment['appointment_time'] }}</p>
            <p>Status: {{ $appointment['status'] }}</p>
                 </div>
               @endforeach
                </div>
                    @endif
                </div>

                <!-- Right Column - Past Appointments -->
                <div class="lg:col-span-1 flex flex-col gap-8">
                    <!-- Past Appointments -->
                    @if(count($pastAppointments) > 0)
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                            Past Appointments
                        </h2>
                        <div class="flex flex-col gap-3">
                            @foreach($pastAppointments as $appointment)
                            <div class="p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold text-sm">
                                        Dr. {{ $appointment['doctor']['user']['name'] ?? 'Unknown' }}
                                    </p>
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        @if($appointment['status'] === 'completed') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/20 dark:text-gray-300
                                        @endif">
                                        {{ ucfirst($appointment['status']) }}
                                    </span>
                                </div>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    {{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M d, Y') }} • {{ $appointment['appointment_time'] }}
                                </p>
                                <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                    {{ $appointment['doctor_detail']['specialization'] ?? 'General Physician' }}
                                </p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Quick Info -->
                    <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                        <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-4">
                            Booking Information
                        </h2>
                        <div class="flex flex-col gap-3">
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">schedule</span>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium">Appointment Duration</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">30 minutes per session</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">payments</span>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium">Consultation Fee</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">$50 per appointment</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3 p-3 rounded-lg bg-background-light dark:bg-background-dark">
                                <span class="material-symbols-outlined text-primary text-lg">cancel</span>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary text-sm font-medium">Cancellation Policy</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-xs">Cancel at least 2 hours before appointment</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>