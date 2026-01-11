<div>
    <div class="relative" x-data="{ open: false }" x-init="
        $watch('open', value => {
            if (value) {
                Livewire.emit('notificationsDropdownOpened');
            }
        })
    ">
    <!-- Notification Bell Button -->
    <button @click="open = !open" 
            :class="open ? 'bg-primary/10 dark:bg-primary/20 text-primary' : 'text-text-light-secondary dark:text-text-dark-secondary hover:bg-primary/10 dark:hover:bg-primary/20'"
            class="relative flex items-center justify-center rounded-lg size-11 transition-all duration-200">
        <span class="material-symbols-outlined text-2xl">notifications</span>
        
        <!-- Unread Count Badge -->
        @if($count > 0)
            <span class="absolute -top-1 -end-1 inline-flex items-center justify-center min-w-5 h-5 px-1 text-xs font-bold text-white bg-red-500 rounded-full border-2 border-white dark:border-card-dark">
                {{ $count > 9 ? '9+' : $count }}
            </span>
        @endif
    </button>

    <!-- Notifications Dropdown -->
    <div x-show="open" 
         x-cloak 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.outside="open = false"
         class="absolute right-0 mt-2 w-96 bg-white dark:bg-card-dark border border-border-light dark:border-border-dark rounded-xl shadow-2xl z-50 overflow-hidden">
        
        <!-- Dropdown Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-primary/5 to-primary/10 dark:from-primary/10 dark:to-primary/20 border-b border-border-light dark:border-border-dark">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">Notifications</h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        {{ $count > 0 ? "You have {$count} unread notifications" : 'No new notifications' }}
                    </p>
                </div>
                @if($count > 0)
                    <button wire:click="markAllAsRead" 
                            @click="open = false"
                            class="flex items-center justify-center rounded-lg h-9 px-4 bg-primary hover:bg-primary/90 text-white text-xs font-bold gap-1 transition-all">
                        <span class="material-symbols-outlined text-sm">done_all</span>
                        Mark All Read
                    </button>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="max-h-[400px] overflow-y-auto">
            @if($notifications->isEmpty())
                <!-- Empty State -->
                <div class="p-8 text-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mx-auto mb-4">
                        <span class="material-symbols-outlined text-gray-400 dark:text-gray-500 text-3xl">notifications_off</span>
                    </div>
                    <h4 class="text-text-light-primary dark:text-text-dark-primary text-base font-semibold mb-2">
                        No new notifications
                    </h4>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        You're all caught up!
                    </p>
                </div>
            @else
                <div class="divide-y divide-border-light dark:divide-border-dark">
                    @foreach($notifications as $notification)
                        @php
                            $data = (array) $notification->data;
                            $type = $data['type'] ?? 'system';
                            $isUnread = !$notification->read_at;
                        @endphp

                        <div class="px-5 py-4 hover:bg-background-light dark:hover:bg-background-dark transition-colors duration-200 
                                    {{ $isUnread ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                            <div class="flex gap-3">
                                <!-- Notification Icon -->
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center w-10 h-10 rounded-lg {{ $this->getNotificationColor($type) }}">
                                        <span class="material-symbols-outlined text-white text-sm">
                                            {{ $this->getNotificationIcon($type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Notification Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <a href="{{ $data['url'] ?? '#' }}" 
                                               @click="open = false"
                                               class="block text-text-light-primary dark:text-text-dark-primary font-semibold text-sm hover:text-primary transition-colors">
                                                {{ $data['title'] ?? 'Notification' }}
                                            </a>
                                            <p class="mt-1 text-text-light-secondary dark:text-text-dark-secondary text-sm">
                                                {{ \Illuminate\Support\Str::limit($data['body'] ?? '', 80) }}
                                            </p>
                                            <div class="mt-2 flex items-center gap-3">
                                                <span class="text-xs px-2 py-1 rounded-full bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300">
                                                    {{ ucfirst($type) }}
                                                </span>
                                                <span class="text-text-light-tertiary dark:text-text-dark-tertiary text-xs">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Mark as Read Button -->
                                        <button wire:click="markAsRead('{{ $notification->id }}')" 
                                                @click="open = false"
                                                class="flex-shrink-0 flex items-center justify-center rounded-lg size-8 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-600 dark:text-green-300 transition-all"
                                                title="Mark as Read">
                                            <span class="material-symbols-outlined text-sm">done</span>
                                        </button>
                                    </div>

                                    <!-- Quick Actions -->
                                    @if(!empty($data['url']) && !empty($data['action']))
                                        <div class="mt-3 pt-3 border-t border-border-light dark:border-border-dark">
                                            <a href="{{ $data['url'] }}" 
                                               @click="open = false"
                                               class="inline-flex items-center justify-center rounded-lg h-8 px-3 bg-primary hover:bg-primary/90 text-white text-xs font-medium gap-1 transition-all">
                                                <span class="material-symbols-outlined text-xs">{{ $data['action_icon'] ?? 'arrow_forward' }}</span>
                                                {{ $data['action'] ?? 'View' }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Dropdown Footer -->
        <div class="border-t border-border-light dark:border-border-dark bg-background-light dark:bg-background-dark">
            <div class="px-5 py-3">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.notifications') }}" 
                       @click="open = false"
                       class="flex items-center gap-2 text-text-light-primary dark:text-text-dark-primary text-sm font-semibold hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-lg">list_alt</span>
                        View All Notifications
                    </a>
                    <div class="text-text-light-tertiary dark:text-text-dark-tertiary text-xs">
                        {{ $count }} unread • {{ auth()->user()->notifications()->count() }} total
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Notification Sound -->
    <audio id="notification-sound" preload="auto">
        <source src="{{ asset('sounds/notification.mp3') }}" type="audio/mpeg">
    </audio>

    <script>
    // Play sound when new notification arrives
    document.addEventListener('livewire:initialized', () => {
        let previousCount = @js($count);
        
        Livewire.hook('commit', ({ component, commit, respond, succeed, fail }) => {
            succeed(() => {
                // Check if notification count increased
                if (component.name === 'admin.notifications-bell') {
                    const newCount = component.get('count');
                    if (newCount > previousCount) {
                        // Play notification sound
                        const audio = document.getElementById('notification-sound');
                        if (audio) {
                            audio.currentTime = 0;
                            audio.play().catch(e => console.log('Audio play failed:', e));
                        }
                        
                        // Show browser notification if permitted
                        if (Notification.permission === 'granted') {
                            new Notification('New Notification', {
                                body: 'You have a new notification',
                                icon: '/favicon.ico'
                            });
                        }
                    }
                    previousCount = newCount;
                }
            });
        });

        // Request notification permission
        if ('Notification' in window && Notification.permission === 'default') {
            setTimeout(() => {
                Notification.requestPermission();
            }, 2000);
        }
    });

    // Auto-refresh notifications every 30 seconds
    setInterval(() => {
        @this.$refresh();
    }, 30000);
    </script>

    <style>
    /* Custom scrollbar for notifications dropdown */
    .max-h-\[400px\]::-webkit-scrollbar {
        width: 6px;
    }
    
    .max-h-\[400px\]::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .max-h-\[400px\]::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    .dark .max-h-\[400px\]::-webkit-scrollbar-thumb {
        background: #475569;
    }
    
    .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    .dark .max-h-\[400px\]::-webkit-scrollbar-thumb:hover {
        background: #64748b;
    }
    </style>
</div>