<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PatientAppointmentConfirmation extends Notification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        $appt = $this->appointment;
        $time = $appt->scheduled_at ? $appt->scheduled_at->format('Y-m-d H:i') : ($appt->appointment_date ?? '');

        return (new MailMessage)
                    ->subject('Appointment Confirmation')
                    ->greeting('Hello ' . ($notifiable->name ?? ''))
                    ->line("Your appointment is booked with Dr. " . ($appt->doctor->name ?? ''))
                    ->line("When: {$time}")
                    ->line('Reason: ' . ($appt->symptoms ?? ''))
                    ->action('View Appointment', url('/patient/appointments'))
                    ->line('Thank you for using our service.');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'appointment_confirmation',
            'title' => 'Appointment Confirmed',
            'body' => 'Your appointment has been booked successfully.',
            'url' => url('/patient/appointments'),
            'appointment_id' => $this->appointment->id ?? null,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
