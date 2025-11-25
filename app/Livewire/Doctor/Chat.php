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
            // Get patients who have recent conversations with this doctor
            $recentChatPatientIds = ChatMessage::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->select('sender_id', 'receiver_id')
                ->get()
                ->flatMap(function ($message) {
                    return [$message->sender_id, $message->receiver_id];
                })
                ->unique()
                ->filter(function ($userId) {
                    return $userId !== auth()->id();
                });

            // Also include patients with appointments but no messages yet
            $appointmentPatientIds = Appointment::where('doctor_id', auth()->id())
                ->whereNotNull('patient_id')
                ->pluck('patient_id')
                ->unique();

            // Combine both and get unique patient IDs
            $allPatientIds = $recentChatPatientIds->merge($appointmentPatientIds)->unique();

            if (empty($allPatientIds)) {
                $this->patients = [];
                return;
            }

            $users = User::whereIn('id', $allPatientIds)->get();

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

        } catch (\Exception $e) {
            Log::error('Error loading recent chats for doctor: ' . $e->getMessage());
            $this->patients = [];
        }
    }

    // ADD THIS METHOD FOR AUTO-REFRESH
    public function pollMessages()
    {
        if ($this->selectedPatient) {
            $this->loadMessages();
            $this->loadRecentChats();
        }
    }

    public function selectPatient($patientId)
    {
        try {
            $this->selectedPatient = User::find($patientId);
            
            if ($this->selectedPatient) {
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

        } catch (\Exception $e) {
            Log::error('Error loading messages for doctor: ' . $e->getMessage());
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required_without:fileUpload',
            'fileUpload' => 'nullable|file|max:10240',
        ]);

        if (!$this->selectedPatient) {
            session()->flash('error', 'Please select a patient first.');
            return;
        }

        try {
            $messageData = [
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedPatient->id,
            ];

            if ($this->fileUpload) {
                $filePath = $this->fileUpload->store('chat_files', 'public');
                $messageData['file_path'] = $filePath;
                $messageData['message_type'] = $this->getFileType($this->fileUpload);
                $messageData['message'] = 'Sent a file';
            } else {
                $messageData['message'] = trim($this->newMessage);
                $messageData['message_type'] = 'text';
            }

            ChatMessage::create($messageData);

            $this->newMessage = '';
            $this->fileUpload = null;
            $this->loadMessages();
            $this->loadRecentChats();
            $this->dispatch('messageSent');

            session()->flash('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            Log::error('Doctor chat message send error: ' . $e->getMessage());
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
        return view('livewire.doctor.chat')
            ->layout('components.layouts.doctor');
    }
}