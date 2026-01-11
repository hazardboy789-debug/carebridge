<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use App\Notifications\SystemAnnouncement;
use Illuminate\Support\Facades\Notification;
use Livewire\Attributes\Layout;
use Illuminate\Notifications\DatabaseNotification;

#[Layout('components.layouts.admin')]
class NotificationsList extends Component
{
    use WithPagination;

    public $filterType = null;
    public $onlyUnread = false;
    
    // Stats properties
    public $totalCount = 0;
    public $unreadCount = 0;
    public $todayCount = 0;
    public $weekCount = 0;
    public $notificationTypes = [];

    protected $listeners = [
        'notificationsUpdated' => '$refresh',
        'notification-marked-read' => 'updateStats',
        'notification-marked-unread' => 'updateStats',
        'notification-deleted' => 'updateStats',
    ];

    public function mount()
    {
        $this->loadStats();
        $this->loadNotificationTypes();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
        $this->loadStats();
    }

    public function updatingOnlyUnread()
    {
        $this->resetPage();
        $this->loadStats();
    }

    private function loadStats()
    {
        $user = auth()->user();
        
        $this->totalCount = $user->notifications()->count();
        $this->unreadCount = $user->unreadNotifications()->count();
        $this->todayCount = $user->notifications()
            ->whereDate('created_at', today())
            ->count();
        $this->weekCount = $user->notifications()
            ->where('created_at', '>=', now()->subWeek())
            ->count();
    }

    private function loadNotificationTypes()
    {
        $user = auth()->user();
        $types = $user->notifications()
            ->selectRaw("DISTINCT JSON_UNQUOTE(JSON_EXTRACT(data, '$.type')) as type")
            ->whereNotNull('data')
            ->get()
            ->pluck('type')
            ->filter()
            ->values()
            ->toArray();
        
        $this->notificationTypes = array_unique(array_merge([
            'appointment',
            'prescription', 
            'donation',
            'announcement',
            'system'
        ], $types));
    }

    public function updateStats()
    {
        $this->loadStats();
        $this->loadNotificationTypes();
    }

    public function markAsRead($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->markAsRead();
            
            $this->dispatch('notificationsUpdated');
            $this->dispatch('notification-marked-read');
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Notification marked as read.',
            ]);
        }
    }

    public function markAsUnread($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->update(['read_at' => null]);
            
            $this->dispatch('notificationsUpdated');
            $this->dispatch('notification-marked-unread');
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Notification marked as unread.',
            ]);
        }
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        
        $this->dispatch('notificationsUpdated');
        $this->dispatch('notification-marked-read');
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'All notifications marked as read.',
        ]);
    }

    public function markAllUnread()
    {
        auth()->user()->notifications()
            ->whereNotNull('read_at')
            ->update(['read_at' => null]);
        
        $this->dispatch('notificationsUpdated');
        $this->dispatch('notification-marked-unread');
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'All notifications marked as unread.',
        ]);
    }
    // Test notification methods removed.

    public function deleteNotification($id)
    {
        $notification = DatabaseNotification::find($id);
        
        if ($notification && $notification->notifiable_id === auth()->id()) {
            $notification->delete();
            
            $this->dispatch('notificationsUpdated');
            $this->dispatch('notification-deleted');
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Notification deleted successfully.',
            ]);
        }
    }

    public function deleteAllRead()
    {
        $deletedCount = auth()->user()->notifications()
            ->whereNotNull('read_at')
            ->delete();
        
        $this->dispatch('notificationsUpdated');
        $this->updateStats();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Deleted {$deletedCount} read notifications.",
        ]);
    }

    public function deleteAllNotifications()
    {
        $deletedCount = auth()->user()->notifications()->delete();
        
        $this->dispatch('notificationsUpdated');
        $this->updateStats();
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Deleted all {$deletedCount} notifications.",
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

    public function getTypeBadgeColor($type)
    {
        return match(strtolower($type)) {
            'appointment' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
            'prescription' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            'donation' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
            'announcement' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-300',
            'system' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
            'emergency' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'alert' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'info' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300',
            default => 'bg-primary/10 text-primary dark:bg-primary/20 dark:text-primary',
        };
    }

    public function getPriorityBadgeColor($priority)
    {
        return match(strtolower($priority)) {
            'high', 'urgent' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
            'medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
            'low' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
            default => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
        };
    }

    public function render()
    {
        $user = auth()->user();

        if ($this->onlyUnread) {
            $query = $user->unreadNotifications();
        } else {
            $query = $user->notifications();
        }

        if ($this->filterType) {
            $query = $query->where('data->type', $this->filterType);
        }

        $notifications = $query->latest()->paginate(10);

        return view('livewire.admin.notifications-list', [
            'notifications' => $notifications,
            'totalCount' => $this->totalCount,
            'unreadCount' => $this->unreadCount,
            'todayCount' => $this->todayCount,
            'weekCount' => $this->weekCount,
            'notificationTypes' => $this->notificationTypes,
        ]);
    }
}