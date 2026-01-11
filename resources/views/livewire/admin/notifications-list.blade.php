<div class="p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Header -->
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                Notification Management
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Manage system notifications and alerts
            </p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Notifications -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900">
                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300">notifications</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Total Notifications</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $totalCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Unread Notifications -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-red-100 dark:bg-red-900">
                        <span class="material-symbols-outlined text-red-500 dark:text-red-300">mail</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Unread Notifications</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $unreadCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Today's Notifications -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-green-100 dark:bg-green-900">
                        <span class="material-symbols-outlined text-green-500 dark:text-green-300">today</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Today's Notifications</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $todayCount }}</p>
                    </div>
                </div>
            </div>

            <!-- This Week -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-purple-100 dark:bg-purple-900">
                        <span class="material-symbols-outlined text-purple-500 dark:text-purple-300">date_range</span>
                    </div>
                    <div>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">This Week</p>
                        <p class="text-text-light-primary dark:text-text-dark-primary text-2xl font-bold">{{ $weekCount }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex flex-col lg:flex-row gap-6 items-start lg:items-center justify-between">
                <!-- Filter Section -->
                <div class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Filter by Type -->
                    <div>
                        <label class="text-text-light-primary dark:text-text-dark-primary text-sm font-semibold mb-2 block">
                            Filter by Type
                        </label>
                        <select wire:model.live="filterType" 
                                class="w-full border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark rounded-lg px-4 py-3 text-text-light-primary dark:text-text-dark-primary focus:ring-2 focus:ring-primary focus:border-transparent">
                            <option value="">All Types</option>
                            @foreach($notificationTypes as $type)
                                <option value="{{ $type }}">{{ ucfirst($type) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Unread Filter -->
                    <div class="flex items-center">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model.live="onlyUnread" 
                                   class="sr-only peer">
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 dark:peer-focus:ring-primary/40 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary"></div>
                            <span class="ml-3 text-sm font-medium text-text-light-primary dark:text-text-dark-primary">
                                Show Unread Only
                            </span>
                        </label>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
                    <!-- Test Buttons -->
                    <!-- Test button removed -->
                    
                    <!-- Bulk Actions -->
                    <div class="relative group">
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-green-500 hover:bg-green-600 text-white text-sm font-bold gap-2 transition-all">
                            <span class="material-symbols-outlined">done_all</span>
                            Mark All
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <button wire:click="markAllAsRead" 
                                    class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Mark All as Read
                            </button>
                            <button wire:click="markAllUnread" 
                                    class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Mark All as Unread
                            </button>
                        </div>
                    </div>
                    
                    <!-- Delete Actions -->
                    <div class="relative group">
                        <button class="flex items-center justify-center rounded-lg h-12 px-6 bg-red-500 hover:bg-red-600 text-white text-sm font-bold gap-2 transition-all">
                            <span class="material-symbols-outlined">delete</span>
                            Delete
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                            <button wire:click="deleteAllRead" 
                                    onclick="return confirm('Are you sure you want to delete all read notifications?')"
                                    class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Delete All Read
                            </button>
                            <button wire:click="deleteAllNotifications" 
                                    onclick="return confirm('Are you sure you want to delete ALL notifications? This action cannot be undone.')"
                                    class="block w-full text-left px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                Delete All Notifications
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark overflow-hidden">
            @if($notifications->isEmpty())
                <!-- Empty State -->
                <div class="p-12 text-center">
                    <div class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                        <span class="material-symbols-outlined text-gray-400 dark:text-gray-500 text-4xl">notifications_off</span>
                    </div>
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-semibold mb-2">
                        No notifications found
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary mb-6">
                        @if($onlyUnread)
                            You have no unread notifications.
                        @else
                            Your notification inbox is empty.
                        @endif
                    </p>
                    <!-- Test notification action removed -->
                </div>
            @else
                <!-- Notifications Table Header -->
                <div class="px-6 py-4 bg-background-light dark:bg-background-dark border-b border-border-light dark:border-border-dark">
                    <div class="grid grid-cols-12 gap-4 text-text-light-secondary dark:text-text-dark-secondary text-sm font-semibold">
                        <div class="col-span-6">Notification</div>
                        <div class="col-span-3">Type</div>
                        <div class="col-span-2">Date</div>
                        <div class="col-span-1">Actions</div>
                    </div>
                </div>

                <!-- Notifications List -->
                <div class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($notifications as $notification)
                        @php
                            $data = (array) $notification->data;
                            $type = $data['type'] ?? 'system';
                            $isUnread = !$notification->read_at;
                            $priority = $data['metadata']['priority'] ?? 'normal';
                        @endphp

                        <div class="px-6 py-4 hover:bg-background-light dark:hover:bg-background-dark transition-colors duration-200 
                                    {{ $isUnread ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <!-- Notification Content -->
                                <div class="col-span-6">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $this->getNotificationColor($type) }}">
                                            <span class="material-symbols-outlined text-white text-sm">
                                                {{ $this->getNotificationIcon($type) }}
                                            </span>
                                        </div>
                                        <div>
                                            <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                                                {{ $data['title'] ?? 'Notification' }}
                                            </p>
                                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mt-1">
                                                {{ Str::limit($data['body'] ?? '', 100) }}
                                            </p>
                                            @if($isUnread)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 mt-2">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Type Badge -->
                                <div class="col-span-3">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs px-3 py-1.5 rounded-full {{ $this->getTypeBadgeColor($type) }}">
                                            {{ ucfirst($type) }}
                                        </span>
                                        @if($priority !== 'normal')
                                            <span class="text-xs px-3 py-1.5 rounded-full {{ $this->getPriorityBadgeColor($priority) }}">
                                                {{ ucfirst($priority) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Date -->
                                <div class="col-span-2">
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                        {{ $notification->created_at->format('M d, Y') }}
                                    </p>
                                    <p class="text-text-light-tertiary dark:text-text-dark-tertiary text-xs">
                                        {{ $notification->created_at->format('h:i A') }}
                                    </p>
                                </div>

                                <!-- Actions -->
                                <div class="col-span-1">
                                    <div class="flex items-center gap-2">
                                        @if($isUnread)
                                            <button wire:click="markAsRead('{{ $notification->id }}')" 
                                                    class="flex items-center justify-center rounded-lg h-9 w-9 bg-green-500 hover:bg-green-600 text-white transition-all"
                                                    title="Mark as Read">
                                                <span class="material-symbols-outlined text-sm">done</span>
                                            </button>
                                        @else
                                            <button wire:click="markAsUnread('{{ $notification->id }}')" 
                                                    class="flex items-center justify-center rounded-lg h-9 w-9 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition-all"
                                                    title="Mark as Unread">
                                                <span class="material-symbols-outlined text-sm">mail</span>
                                            </button>
                                        @endif

                                        <button wire:click="deleteNotification('{{ $notification->id }}')" 
                                                onclick="return confirm('Are you sure you want to delete this notification?')"
                                                class="flex items-center justify-center rounded-lg h-9 w-9 bg-red-100 dark:bg-red-900 hover:bg-red-200 dark:hover:bg-red-800 text-red-600 dark:text-red-300 transition-all"
                                                title="Delete">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Metadata -->
                            @if(!empty($data['metadata']))
                                <div class="mt-3 pt-3 border-t border-border-light dark:border-border-dark">
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($data['metadata'] as $key => $value)
                                            @if(!in_array($key, ['priority']))
                                                <div class="flex items-center gap-1">
                                                    <span class="text-text-light-secondary dark:text-text-dark-secondary text-xs">
                                                        {{ str_replace('_', ' ', $key) }}:
                                                    </span>
                                                    <span class="text-text-light-primary dark:text-text-dark-primary text-xs font-medium">
                                                        {{ is_array($value) ? json_encode($value) : $value }}
                                                    </span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between">
                    <div class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} notifications
                    </div>
                    <div>
                        {{ $notifications->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>