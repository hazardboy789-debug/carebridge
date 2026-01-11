<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Notifications\DatabaseNotification;

#[Layout('components.layouts.admin')]
class NotificationsBell extends Component
{
    public $show = false;

    protected $listeners = [
        'notificationsUpdated' => '$refresh',
        'notification-marked-read' => '$refresh',
        'notification-marked-unread' => '$refresh',
        'notification-deleted' => '$refresh',
    ];

    public function toggle()
    {
        $this->show = !$this->show;
        if (!$this->show) {
            // When closing the dropdown, we could mark notifications as seen but not read
            // For now, just close the dropdown
        }
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
            
            $this->emit('notificationsUpdated');
            $this->dispatch('notification-marked-read');
            
            // Dispatch a notification event for UI feedback
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Notification marked as read',
            ]);
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        $this->emit('notificationsUpdated');
        $this->dispatch('notification-marked-read');
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'All notifications marked as read',
        ]);
    }

    public function getNotificationColor($type)
    {
        return match(strtolower($type)) {
            'appointment' => 'bg-blue-500',
            'prescription' => 'bg-green-500',
            'donation' => 'bg-purple-500',
            'announcement' => 'bg-orange-500',
            'system' => 'bg-gray-500',
            'emergency' => 'bg-red-500',
            'alert' => 'bg-yellow-500',
            'info' => 'bg-indigo-500',
            default => 'bg-primary',
        };
    }

    public function getNotificationIcon($type)
    {
        return match(strtolower($type)) {
            'appointment' => 'event',
            'prescription' => 'medical_information',
            'donation' => 'volunteer_activism',
            'announcement' => 'campaign',
            'system' => 'settings',
            'emergency' => 'emergency',
            'alert' => 'warning',
            'info' => 'info',
            default => 'notifications',
        };
    }

    public function render()
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->take(6) // Show only 6 most recent
            ->get();
            
        $count = auth()->user()->unreadNotifications()->count();
        
        return view('livewire.admin.notifications-bell', compact('notifications', 'count'));
    }
}