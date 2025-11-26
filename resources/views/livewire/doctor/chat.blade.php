<div class="p-6">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Chat with Patients</h1>
            <p class="text-gray-600 dark:text-gray-400">Recent conversations with your patients</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-[600px]">
            <!-- Recent Chats List -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="font-semibold text-gray-900 dark:text-white">Recent Chats</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ count($patients) }} conversations</p>
                </div>
                
                <div class="overflow-y-auto h-[500px]">
                    @if(count($patients) > 0)
                        @foreach($patients as $patient)
                            <div wire:click="selectPatient({{ $patient['id'] }})" 
                                 class="p-4 border-b border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedPatient && $selectedPatient->id === $patient['id'] ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">
                                                {{ substr($patient['name'], 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $patient['name'] }}
                                        </p>
                                        @if($patient['last_message'])
                                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                                @if($patient['last_message']->sender_id === auth()->id())
                                                    You: {{ Str::limit($patient['last_message']->message, 25) }}
                                                @else
                                                    {{ Str::limit($patient['last_message']->message, 25) }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ $patient['last_message']->created_at->diffForHumans() }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-500">No messages yet</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">Start a conversation</p>
                                        @endif
                                    </div>
                                    @if($patient['unread_count'] > 0)
                                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                            {{ $patient['unread_count'] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="font-medium mb-1">No conversations yet</p>
                            <p class="text-sm">Your chat history with patients will appear here</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chat Area -->
            <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col">
                @if($selectedPatient)
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                    <span class="text-green-600 dark:text-green-400 font-semibold text-sm">
                                        {{ substr($selectedPatient->name, 0, 2) }}
                                    </span>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">
                                        {{ $selectedPatient->name }}
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        Patient • {{ $selectedPatient->email }}
                                    </p>
                                </div>
                            </div>
                            <!-- Prescription Button -->
                            <button type="button" 
                                    wire:click="$dispatch('openPrescriptionModal', { patientId: {{ $selectedPatient->id }} })"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Send Prescription
                            </button>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                        @foreach($messages as $message)
                            <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg 
                                    {{ $message->sender_id === auth()->id() 
                                        ? 'bg-blue-600 text-white rounded-br-none' 
                                        : 'bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-white rounded-bl-none' }}">
                                    
                                    @if($message->message_type === 'text')
                                        <p class="text-sm">{{ $message->message }}</p>
                                    @elseif($message->message_type === 'image')
                                        <div class="space-y-2">
                                            <img src="{{ asset('storage/' . $message->file_path) }}" 
                                                 alt="Shared image" 
                                                 class="rounded-lg max-w-full h-auto">
                                            <p class="text-xs opacity-75">Shared an image</p>
                                        </div>
                                    @else
                                        <div class="space-y-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <span class="text-sm">File attached</span>
                                            </div>
                                            <a href="{{ asset('storage/' . $message->file_path) }}" 
                                               download
                                               class="text-xs text-blue-400 hover:text-blue-300 underline">
                                                Download file
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <p class="text-xs mt-1 opacity-75 text-right">
                                        {{ $message->created_at->format('h:i A') }}
                                        @if($message->sender_id === auth()->id() && $message->read_at)
                                            <span class="ml-1 text-green-400">✓ Read</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                        <form wire:submit.prevent="sendMessage" class="space-y-3">
                            <!-- Flash Messages -->
                            @if(session()->has('error'))
                                <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded">
                                    <p class="text-sm text-red-700 dark:text-red-300">{{ session('error') }}</p>
                                </div>
                            @endif

                            @if(session()->has('success'))
                                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded">
                                    <p class="text-sm text-green-700 dark:text-green-300">{{ session('success') }}</p>
                                </div>
                            @endif

                            @if($fileUpload)
                                <div class="flex items-center justify-between p-2 bg-blue-50 dark:bg-blue-900/20 rounded">
                                    <span class="text-sm text-blue-700 dark:text-blue-300">
                                        File: {{ $fileUpload->getClientOriginalName() }}
                                    </span>
                                    <button type="button" wire:click="$set('fileUpload', null)" class="text-red-500 hover:text-red-700">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endif

                            <div class="flex space-x-2">
                                <input type="text" 
                                       wire:model="newMessage"
                                       wire:keydown.enter.prevent="sendMessage"
                                       placeholder="Type your message..."
                                       class="flex-1 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                                
                                <label for="file-upload" class="cursor-pointer px-3 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                    </svg>
                                    <input id="file-upload" type="file" wire:model="fileUpload" class="hidden" accept="image/*,.pdf,.doc,.docx">
                                </label>
                                
                                <button type="submit" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center disabled:opacity-50 disabled:cursor-not-allowed"
                                        wire:loading.attr="disabled"
                                        wire:target="sendMessage">
                                    <span wire:loading.remove wire:target="sendMessage">Send</span>
                                    <span wire:loading wire:target="sendMessage">
                                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="flex-1 flex items-center justify-center text-gray-500 dark:text-gray-400">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-lg font-medium">Select a conversation to start chatting</p>
                            <p class="text-sm">Choose from your recent chats on the left</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Prescription Modal -->
    @livewire('doctor.prescription-modal')

    @script
    <script>
        // Auto-scroll to bottom when new messages arrive
        $wire.on('messageSent', () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        // Listen for prescription creation
        $wire.on('prescriptionCreated', () => {
            // Refresh the chat when prescription is created
            $wire.refreshOnPrescription();
        });

        // Auto-scroll when component loads
        document.addEventListener('livewire:init', () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });

        // Auto-scroll when messages are loaded
        document.addEventListener('livewire:load', () => {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
    @endscript
</div>