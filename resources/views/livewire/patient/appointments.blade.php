<div>
    <!-- Success Message -->
    @if(session('booking_success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('booking_success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Appointments</h2>
        <button wire:click="openBooking" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Book New Appointment
        </button>
    </div>

    <!-- Upcoming Appointments -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Upcoming Appointments</h5>
        </div>
        <div class="card-body">
            @if(count($upcomingAppointments) > 0)
                @foreach($upcomingAppointments as $appointment)
                    <div class="appointment-item border-bottom pb-3 mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Dr. {{ $appointment['doctor']['name'] ?? 'N/A' }}</h6>
                                <p class="mb-1">
                                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M d, Y') }}
                                </p>
                                <p class="mb-1">
                                    <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment['appointment_time'])->format('h:i A') }}
                                </p>
                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    <span class="badge 
                                        @if($appointment['status'] == 'confirmed') bg-success
                                        @elseif($appointment['status'] == 'pending') bg-warning
                                        @elseif($appointment['status'] == 'cancelled') bg-danger
                                        @else bg-secondary @endif">
                                        {{ ucfirst($appointment['status']) }}
                                    </span>
                                </p>
                                @if($appointment['symptoms'])
                                    <p class="mb-0"><strong>Reason:</strong> {{ $appointment['symptoms'] }}</p>
                                @endif
                            </div>
                            <div class="col-md-4 text-end">
                                @if($appointment['status'] == 'pending')
                                    <button wire:click="cancelAppointment({{ $appointment['id'] }})" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">No upcoming appointments.</p>
            @endif
        </div>
    </div>

    <!-- Past Appointments -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Past Appointments</h5>
        </div>
        <div class="card-body">
            @if(count($pastAppointments) > 0)
                @foreach($pastAppointments as $appointment)
                    <div class="appointment-item border-bottom pb-3 mb-3">
                        <div class="row">
                            <div class="col-md-8">
                                <h6>Dr. {{ $appointment['doctor']['name'] ?? 'N/A' }}</h6>
                                <p class="mb-1">
                                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment['appointment_date'])->format('M d, Y') }}
                                </p>
                                <p class="mb-1">
                                    <strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment['appointment_time'])->format('h:i A') }}
                                </p>
                                <p class="mb-1">
                                    <strong>Status:</strong> 
                                    <span class="badge 
                                        @if($appointment['status'] == 'completed') bg-success
                                        @elseif($appointment['status'] == 'cancelled') bg-danger
                                        @else bg-secondary @endif">
                                        {{ ucfirst($appointment['status']) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">No past appointments.</p>
            @endif
        </div>
    </div>

    <!-- Booking Modal -->
    @if($showBookingModal)
    <div class="modal show d-block" tabindex="-1" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if($selectedDoctor)
                            Book Appointment with Dr. {{ $selectedDoctor->name }}
                        @else
                            Book New Appointment
                        @endif
                    </h5>
                    <button wire:click="resetBooking" class="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="bookAppointment">
                        <!-- Doctor Selection -->
                        @if(!$selectedDoctor)
                        <div class="mb-3">
                            <label class="form-label">Select Doctor *</label>
                            <select wire:model="selectedDoctorId" class="form-select @error('selectedDoctorId') is-invalid @enderror">
                                <option value="">Choose a doctor...</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">
                                        Dr. {{ $doctor->name }} - {{ $doctor->doctorDetail->specialization ?? 'General Practitioner' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('selectedDoctorId') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @else
                        <div class="alert alert-info">
                            <strong>Selected Doctor:</strong> Dr. {{ $selectedDoctor->name }} - {{ $selectedDoctor->doctorDetail->specialization ?? 'General Practitioner' }}
                        </div>
                        @endif

                        <!-- Date Selection -->
                        <div class="mb-3">
                            <label class="form-label">Appointment Date *</label>
                            <input type="date" wire:model="bookingDate" 
                                   class="form-control @error('bookingDate') is-invalid @enderror" 
                                   min="{{ now()->addDay()->format('Y-m-d') }}">
                            @error('bookingDate') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Time Selection -->
                        <div class="mb-3">
                            <label class="form-label">Appointment Time *</label>
                            <select wire:model="bookingTime" class="form-select @error('bookingTime') is-invalid @enderror">
                                <option value="">Choose time...</option>
                                @foreach($availableSlots as $slot)
                                    <option value="{{ $slot }}">{{ \Carbon\Carbon::parse($slot)->format('h:i A') }}</option>
                                @endforeach
                            </select>
                            @error('bookingTime') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if($bookingDate && $bookingTime && !$checkSlotAvailability())
                                <div class="text-danger small mt-1">
                                    ⚠️ This time slot is not available. Please choose another time.
                                </div>
                            @endif
                        </div>

                        <!-- Reason -->
                        <div class="mb-3">
                            <label class="form-label">Reason for Appointment *</label>
                            <textarea wire:model="bookingReason" class="form-control @error('bookingReason') is-invalid @enderror" 
                                      rows="4" placeholder="Please describe your symptoms or reason for appointment..."></textarea>
                            @error('bookingReason') 
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" wire:click="resetBooking" class="btn btn-secondary">Cancel</button>
                            <button type="submit" class="btn btn-primary" 
                                    {{ !$checkSlotAvailability() ? 'disabled' : '' }}>
                                Book Appointment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>