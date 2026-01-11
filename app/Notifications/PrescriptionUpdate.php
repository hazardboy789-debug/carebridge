<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class PrescriptionUpdate extends Notification implements ShouldQueue
{
    use Queueable;

    protected $prescription;

    public function __construct($prescription)
    {
        $this->prescription = $prescription;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Prescription Updated')
                    ->line('A prescription has been updated for you.')
                    ->action('View Prescription', url('/prescriptions/'.$this->prescription->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'prescription',
            'title' => 'Prescription Update',
            'body' => "Prescription #{$this->prescription->id} updated",
            'url' => url('/prescriptions/'.$this->prescription->id),
            'prescription_id' => $this->prescription->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
