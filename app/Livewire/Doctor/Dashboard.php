<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Appointment;
use App\Models\User;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

#[Layout('components.layouts.doctor')]
class Dashboard extends Component
{
    public $todayAppointments = 0;
    public $totalPatients = 0;
    public $upcomingAppointments = 0;
    public $revenueThisMonth = 0;
    public $recentAppointments = [];
    public $todaysSchedule = [];
    public $recentChats = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentChats();
    }

    public function loadStats()
    {
        $doctorId = auth()->id();

        // Cache stats for better performance
        $this->todayAppointments = Cache::remember('doctor_today_appointments_' . $doctorId, 60, function () use ($doctorId) {
            return Appointment::where('doctor_id', $doctorId)
                ->whereDate('appointment_date', Carbon::today())
                ->count();
        });

        $this->totalPatients = Cache::remember('doctor_total_patients_' . $doctorId, 300, function () use ($doctorId) {
            return Appointment::where('doctor_id', $doctorId)
                ->distinct('patient_id')
                ->count('patient_id');
        });

        $this->upcomingAppointments = Cache::remember('doctor_upcoming_appointments_' . $doctorId, 60, function () use ($doctorId) {
            return Appointment::where('doctor_id', $doctorId)
                ->where('appointment_date', '>', now())
                ->whereIn('status', ['scheduled', 'confirmed'])
                ->count();
        });

        $this->revenueThisMonth = Cache::remember('doctor_revenue_month_' . $doctorId, 300, function () use ($doctorId) {
            return Appointment::where('doctor_id', $doctorId)
                ->whereMonth('appointment_date', now()->month)
                ->whereYear('appointment_date', now()->year)
                ->where('status', 'completed')
                ->sum('fee') ?? 0;
        });

        // Recent appointments
        $this->recentAppointments = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        // Today's schedule
        $this->todaysSchedule = Appointment::with('patient')
            ->where('doctor_id', $doctorId)
            ->whereDate('appointment_date', Carbon::today())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->orderBy('appointment_date', 'asc')
            ->get();
    }

    public function loadRecentChats()
    {
        $doctorId = auth()->id();

        // Get patients who have recent chat messages with this doctor
        $recentPatientIds = ChatMessage::where('receiver_id', $doctorId)
            ->orWhere('sender_id', $doctorId)
            ->distinct()
            ->pluck('sender_id', 'receiver_id')
            ->flatten()
            ->unique()
            ->filter(function ($userId) use ($doctorId) {
                return $userId != $doctorId; // Exclude the doctor's own ID
            });

        $this->recentChats = User::whereIn('id', $recentPatientIds)
            ->with(['userDetails'])
            ->get()
            ->map(function ($patient) use ($doctorId) {
                $lastMessage = ChatMessage::where(function ($query) use ($patient, $doctorId) {
                        $query->where('sender_id', $patient->id)
                              ->where('receiver_id', $doctorId);
                    })
                    ->orWhere(function ($query) use ($patient, $doctorId) {
                        $query->where('sender_id', $doctorId)
                              ->where('receiver_id', $patient->id);
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                $unreadCount = ChatMessage::where('sender_id', $patient->id)
                    ->where('receiver_id', $doctorId)
                    ->whereNull('read_at')
                    ->count();

                return [
                    'patient' => $patient,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_message_time' => $lastMessage ? $lastMessage->created_at : null,
                ];
            })
            ->sortByDesc('last_message_time')
            ->take(5)
            ->values();
    }

    public function completeAppointment($appointmentId)
    {
        $appointment = Appointment::where('doctor_id', auth()->id())
            ->where('id', $appointmentId)
            ->first();

        if ($appointment) {
            $appointment->update(['status' => 'completed']);
            session()->flash('message', 'Appointment marked as completed.');
            $this->loadStats(); // Refresh stats
        }
    }

    public function cancelAppointment($appointmentId)
    {
        $appointment = Appointment::where('doctor_id', auth()->id())
            ->where('id', $appointmentId)
            ->first();

        if ($appointment) {
            $appointment->update(['status' => 'cancelled']);
            session()->flash('message', 'Appointment cancelled.');
            $this->loadStats(); // Refresh stats
        }
    }

    public function render()
    {
        return view('livewire.doctor.dashboard');
    }
}