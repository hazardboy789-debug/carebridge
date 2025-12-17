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
                            <div wire:click="selectPatient({{ $patient->id }})" 
                                 class="p-4 border-b border-gray-200 dark:border-gray-700 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors {{ $selectedPatient && $selectedPatient->id === $patient->id ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                            <span class="text-green-600 dark:text-green-400 font-semibold text-sm">
                                                {{ substr($patient->name, 0, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-medium text-gray-900 dark:text-white truncate">
                                            {{ $patient->name }}
                                        </p>
                                        @if($patient->last_message)
                                            <p class="text-sm text-gray-600 dark:text-gray-400 truncate">
                                                @if($patient->last_message->sender_id === auth()->id())
                                                    You: {{ Str::limit($patient->last_message->message, 25) }}
                                                @else
                                                    {{ Str::limit($patient->last_message->message, 25) }}
                                                @endif
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">
                                                {{ $patient->last_message->created_at->diffForHumans() }}
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-500">No messages yet</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-500">Start a conversation</p>
                                        @endif
                                    </div>
                                    @if($patient->unread_count > 0)
                                        <span class="bg-red-500 text-white text-xs rounded-full px-2 py-1 min-w-[20px] text-center">
                                            {{ $patient->unread_count }}
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
                                    
                                    @elseif($message->message_type === 'prescription')
                                        @php
                                            $metadata = json_decode($message->metadata, true);
                                        @endphp
                                        <!-- Prescription Message -->
                                        <div class="space-y-3">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-medium text-sm">Medical Prescription</p>
                                                    <p class="text-sm">{{ $message->message }}</p>
                                                    @if(isset($metadata['diagnosis']))
                                                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                                            Diagnosis: {{ Str::limit($metadata['diagnosis'], 50) }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="flex items-center justify-between">
                                                <span class="text-xs text-gray-500 dark:text-gray-400">
                                                    PDF Document • {{ $message->file_size ? round($message->file_size / 1024) : 'N/A' }} KB
                                                </span>
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('prescription.download', $message->id) }}" 
                                                       target="_blank"
                                                       class="text-xs px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                                        Download PDF
                                                    </a>
                                                    @if(isset($metadata['prescription_id']))
                                                        <button wire:click="viewPrescription({{ $metadata['prescription_id'] }})"
                                                                class="text-xs px-3 py-1 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                                            View Details
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    
                                    @else
                                        <!-- Regular File -->
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

    <!-- Prescription Modal -->
    @livewire('doctor.prescription-modal')

    <!-- Prescription Details Modal -->
    @if($showPrescriptionDetails)
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" wire:click="$set('showPrescriptionDetails', false)"></div>

                <!-- Modal Panel -->
                <div class="inline-block w-full max-w-4xl my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-gray-800 rounded-lg shadow-xl">
                    <!-- Header -->
                    <div class="px-6 py-4 bg-green-50 dark:bg-green-900/20 border-b border-green-200 dark:border-green-800">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Prescription Details
                            </h3>
                            <button wire:click="$set('showPrescriptionDetails', false)" class="text-gray-400 hover:text-gray-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Prescription Details -->
                    <div class="px-6 py-4 max-h-[70vh] overflow-y-auto">
                        @if($selectedPrescription)
                            <div class="space-y-6">
                                <!-- Basic Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Patient Information</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            {{ $selectedPrescription->patient->name }}<br>
                                            {{ $selectedPrescription->patient->email }}
                                        </p>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Prescription Details</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Date: {{ $selectedPrescription->prescription_date->format('M d, Y') }}<br>
                                            Status: <span class="px-2 py-1 text-xs rounded-full {{ $selectedPrescription->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ ucfirst($selectedPrescription->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <!-- Diagnosis -->
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-2">Diagnosis</h4>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                                        {{ $selectedPrescription->diagnosis }}
                                    </p>
                                </div>

                                <!-- Medications -->
                                <div>
                                    <h4 class="font-medium text-gray-900 dark:text-white mb-3">Prescribed Medications</h4>
                                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg overflow-hidden">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead class="bg-gray-100 dark:bg-gray-700">
                                                <tr>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Medication</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Dosage</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Frequency</th>
                                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider">Duration</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                                @foreach(json_decode($selectedPrescription->medications, true) as $medication)
                                                    @php
                                                        $parts = explode('|', $medication);
                                                        $name = $parts[0] ?? $medication;
                                                        $dosage = $parts[1] ?? 'As directed';
                                                        $frequency = $parts[2] ?? 'Daily';
                                                        $duration = $parts[3] ?? '7 days';
                                                    @endphp
                                                    <tr>
                                                        <td class="px-4 py-3 text-sm text-gray-900 dark:text-white">{{ $name }}</td>
                                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $dosage }}</td>
                                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $frequency }}</td>
                                                        <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $duration }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Instructions & Notes -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Instructions</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                                            {{ $selectedPrescription->instructions }}
                                        </p>
                                    </div>
                                    @if($selectedPrescription->notes)
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Additional Notes</h4>
                                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                                            {{ $selectedPrescription->notes }}
                                        </p>
                                    </div>
                                    @endif
                                </div>

                                <!-- Lab Tests & Follow-up -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    @if($selectedPrescription->lab_tests && !empty(json_decode($selectedPrescription->lab_tests, true)))
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Recommended Lab Tests</h4>
                                        <ul class="list-disc list-inside text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded space-y-1">
                                            @foreach(json_decode($selectedPrescription->lab_tests, true) as $test)
                                                <li>{{ $test }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    @if($selectedPrescription->follow_up_date)
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Follow-up</h4>
                                        <div class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 p-3 rounded">
                                            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($selectedPrescription->follow_up_date)->format('M d, Y') }}</p>
                                            <p class="mt-1">Please schedule a follow-up appointment to review progress.</p>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex justify-end space-x-3">
                                        <a href="{{ route('prescription.download-by-id', $selectedPrescription->id) }}"
                                           target="_blank"
                                           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                            Download PDF
                                        </a>
                                        <button wire:click="$set('showPrescriptionDetails', false)"
                                                class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                                            Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p>Prescription details not found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

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
            // Refresh messages when prescription is created
            Livewire.dispatch('refresh-messages');
            
            // Auto-scroll to bottom
            setTimeout(() => {
                const container = document.getElementById('messages-container');
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 500);
        });

        // Listen for open prescription modal
        Livewire.on('openPrescriptionModal', (data) => {
            // This will be handled by the prescription-modal component
            console.log('Opening prescription modal for patient:', data.patientId);
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

        // Listen for prescription details modal
        Livewire.on('showPrescriptionDetails', (data) => {
            // Handle prescription details modal opening
            console.log('Showing prescription details:', data);
        });
    </script>
    @endscript
</div>