<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class AppointmentReminder extends Notification implements ShouldQueue
{
    use Queueable;

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
        return (new MailMessage)
                    ->subject('Appointment Reminder')
                    ->line('You have an appointment scheduled.')
                    ->action('View Appointment', url('/appointments/'.$this->appointment->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'appointment',
            'title' => 'Appointment Reminder',
            'body' => "Appointment with {$this->appointment->doctor_name} at {$this->appointment->starts_at}",
            'url' => url('/appointments/'.$this->appointment->id),
            'appointment_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
