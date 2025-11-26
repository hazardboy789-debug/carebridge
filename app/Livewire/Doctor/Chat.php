<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.doctor')]
class Chat extends Component
{
    use WithFileUploads;

    public $patients = [];
    public $selectedPatient = null;
    public $messages = [];
    public $newMessage = '';
    public $fileUpload;

    public function mount()
    {
        $this->loadRecentChats();
    }

    public function loadRecentChats()
    {
        try {
            \Log::info('Loading recent chats for doctor: ' . auth()->id());

            // Get ALL patients who have appointments with this doctor
            $appointmentPatientIds = Appointment::where('doctor_id', auth()->id())
                ->whereNotNull('patient_id')
                ->distinct()
                ->pluck('patient_id')
                ->toArray();

            \Log::info('Appointment patient IDs:', $appointmentPatientIds);

            if (empty($appointmentPatientIds)) {
                $this->patients = [];
                \Log::info('No appointment patients found');
                return;
            }

            // Get users with their latest message
            $users = User::whereIn('id', $appointmentPatientIds)->get();

            \Log::info('Found users: ' . $users->count());

            $this->patients = $users->map(function($user) {
                $lastMessage = $this->getLastMessage($user->id);
                $unreadCount = $this->getUnreadCount($user->id);

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                    'last_activity' => $lastMessage ? $lastMessage->created_at : now()->subYears(10),
                ];
            })->sortByDesc('last_activity')->values()->toArray();

            \Log::info('Processed patients:', ['count' => count($this->patients)]);

        } catch (\Exception $e) {
            Log::error('Error loading recent chats for doctor: ' . $e->getMessage());
            $this->patients = [];
        }
    }

    // Add this method to handle prescription creation
    public function refreshOnPrescription()
    {
        $this->loadRecentChats();
        if ($this->selectedPatient) {
            $this->loadMessages();
        }
    }

    public function selectPatient($patientId)
    {
        try {
            $this->selectedPatient = User::find($patientId);
            
            if ($this->selectedPatient) {
                \Log::info('Selected patient: ' . $this->selectedPatient->name);
                $this->loadMessages();
                $this->markMessagesAsRead();
                $this->dispatch('messageSent');
            }
        } catch (\Exception $e) {
            Log::error('Error selecting patient: ' . $e->getMessage());
        }
    }

    public function loadMessages()
    {
        if (!$this->selectedPatient) {
            $this->messages = [];
            return;
        }

        try {
            $this->messages = ChatMessage::where(function ($query) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $this->selectedPatient->id);
                })
                ->orWhere(function ($query) {
                    $query->where('sender_id', $this->selectedPatient->id)
                          ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at', 'asc')
                ->get();

            \Log::info('Loaded messages: ' . $this->messages->count());

        } catch (\Exception $e) {
            Log::error('Error loading messages for doctor: ' . $e->getMessage());
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        // Validate input
        if (empty($this->newMessage) && !$this->fileUpload) {
            session()->flash('error', 'Please enter a message or select a file.');
            return;
        }

        if (!$this->selectedPatient) {
            session()->flash('error', 'Please select a patient first.');
            return;
        }

        try {
            // Prepare message data
            $messageData = [
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedPatient->id,
            ];

            // Handle file upload
            if ($this->fileUpload) {
                // Validate file
                $this->validate([
                    'fileUpload' => 'file|max:10240',
                ]);

                $filePath = $this->fileUpload->store('chat_files', 'public');
                $messageData['file_path'] = $filePath;
                $messageData['message_type'] = $this->getFileType($this->fileUpload);
                $messageData['message'] = 'Sent a file';
            } else {
                // Validate text message
                $this->validate([
                    'newMessage' => 'required|string|min:1',
                ]);

                $messageData['message'] = trim($this->newMessage);
                $messageData['message_type'] = 'text';
            }

            // Create the chat message
            ChatMessage::create($messageData);

            // Reset form
            $this->newMessage = '';
            $this->fileUpload = null;

            // Reload messages
            $this->loadMessages();
            $this->loadRecentChats();

            // Dispatch event
            $this->dispatch('messageSent');

            session()->flash('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            // Log error for debugging
            Log::error('Chat message send error: ' . $e->getMessage());
            session()->flash('error', 'Failed to send message. Please try again.');
        }
    }

    private function getFileType($file)
    {
        $mimeType = $file->getMimeType();
        
        if (str_starts_with($mimeType, 'image/')) {
            return 'image';
        } else {
            return 'file';
        }
    }

    public function markMessagesAsRead()
    {
        if ($this->selectedPatient) {
            ChatMessage::where('sender_id', $this->selectedPatient->id)
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
                
            $this->loadRecentChats();
        }
    }

    public function getUnreadCount($patientId)
    {
        return ChatMessage::where('sender_id', $patientId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();
    }

    public function getLastMessage($patientId)
    {
        return ChatMessage::where(function ($query) use ($patientId) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $patientId);
            })
            ->orWhere(function ($query) use ($patientId) {
                $query->where('sender_id', $patientId)
                      ->where('receiver_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function updatedFileUpload()
    {
        $this->validate([
            'fileUpload' => 'nullable|file|max:10240',
        ]);
    }

    public function render()
    {
        return view('livewire.doctor.chat');
    }
}