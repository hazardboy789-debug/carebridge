<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class HealthCreditDonation extends Notification implements ShouldQueue
{
    use Queueable;

    protected $donation;

    public function __construct($donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable)
    {
        return ['database', 'mail', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Health Credit Donation')
                    ->line("A donor has contributed {$this->donation->amount} credits.")
                    ->action('View Donation', url('/donations/'.$this->donation->id));
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'donation',
            'title' => 'Health Credit Donation',
            'body' => "{$this->donation->donor_name} donated {$this->donation->amount} credits",
            'url' => url('/donations/'.$this->donation->id),
            'donation_id' => $this->donation->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toDatabase($notifiable));
    }
}
