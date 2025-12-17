<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;

#[Layout('components.layouts.patient')]
class Chat extends Component
{
    use WithFileUploads;

    public $doctors = [];
    public $selectedDoctor = null;
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
            // Get doctors who have recent conversations with this patient
            $recentChatDoctorIds = ChatMessage::where('sender_id', auth()->id())
                ->orWhere('receiver_id', auth()->id())
                ->select('sender_id', 'receiver_id')
                ->get()
                ->flatMap(function ($message) {
                    return [$message->sender_id, $message->receiver_id];
                })
                ->unique()
                ->filter(function ($userId) {
                    return $userId !== auth()->id(); // Exclude current patient
                });

            // Also include doctors with appointments but no messages yet
            $appointmentDoctorIds = Appointment::where('patient_id', auth()->id())
                ->whereNotNull('doctor_id')
                ->pluck('doctor_id')
                ->unique();

            // Combine both and get unique doctor IDs
            $allDoctorIds = $recentChatDoctorIds->merge($appointmentDoctorIds)->unique();

            if ($allDoctorIds->isEmpty()) {
                $this->doctors = [];
                return;
            }

            $users = User::whereIn('id', $allDoctorIds)->get();

            // Build an array of plain objects (stdClass) so Livewire can serialize safely
            $this->doctors = $users->map(function($user) {
                $lastMessageModel = $this->getLastMessage($user->id);
                $unreadCount = $this->getUnreadCount($user->id);

                $lastMessage = null;
                if ($lastMessageModel) {
                    $lastMessage = new \stdClass();
                    $lastMessage->id = $lastMessageModel->id;
                    $lastMessage->sender_id = $lastMessageModel->sender_id;
                    $lastMessage->receiver_id = $lastMessageModel->receiver_id;
                    $lastMessage->message = $lastMessageModel->message;
                    $lastMessage->message_type = $lastMessageModel->message_type;
                    $lastMessage->file_path = $lastMessageModel->file_path;
                    $lastMessage->created_at = $lastMessageModel->created_at; // Carbon instance
                    $lastMessage->read_at = $lastMessageModel->read_at;
                }

                $doc = new \stdClass();
                $doc->id = $user->id;
                $doc->name = $user->name;
                $doc->email = $user->email;
                $doc->last_message = $lastMessage;
                $doc->unread_count = $unreadCount;
                $doc->last_activity = $lastMessage ? $lastMessage->created_at : now()->subYears(10);

                return $doc;
            })->sortByDesc(function($doc) { return $doc->last_activity; })->values()->all();

        } catch (\Exception $e) {
            Log::error('Error loading recent chats for patient: ' . $e->getMessage());
            $this->doctors = [];
        }
    }

    public function selectDoctor($doctorId)
    {
        try {
            $this->selectedDoctor = User::find($doctorId);
            
            if ($this->selectedDoctor) {
                $this->loadMessages();
                $this->markMessagesAsRead();
                $this->dispatch('messageSent');
            }
        } catch (\Exception $e) {
            Log::error('Error selecting doctor: ' . $e->getMessage());
        }
    }

    public function loadMessages()
    {
        if (!$this->selectedDoctor) {
            $this->messages = [];
            return;
        }

        try {
            $messages = ChatMessage::where(function ($query) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $this->selectedDoctor->id);
                })
                ->orWhere(function ($query) {
                    $query->where('sender_id', $this->selectedDoctor->id)
                          ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at', 'asc')
                ->get();

            // Convert message models to simple objects preserving Carbon dates
            $this->messages = $messages->map(function($m) {
                $o = new \stdClass();
                $o->id = $m->id;
                $o->sender_id = $m->sender_id;
                $o->receiver_id = $m->receiver_id;
                $o->message = $m->message;
                $o->message_type = $m->message_type;
                $o->file_path = $m->file_path;
                $o->created_at = $m->created_at; // Carbon
                $o->read_at = $m->read_at;
                return $o;
            })->all();

        } catch (\Exception $e) {
            Log::error('Error loading messages for patient: ' . $e->getMessage());
            $this->messages = [];
        }
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required_without:fileUpload',
            'fileUpload' => 'nullable|file|max:10240',
        ]);

        if (!$this->selectedDoctor) {
            session()->flash('error', 'Please select a doctor first.');
            return;
        }

        try {
            $messageData = [
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedDoctor->id,
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
            $this->loadRecentChats(); // Refresh the recent chats list
            $this->dispatch('messageSent');

            session()->flash('success', 'Message sent successfully!');

        } catch (\Exception $e) {
            Log::error('Patient chat message send error: ' . $e->getMessage());
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
        if ($this->selectedDoctor) {
            ChatMessage::where('sender_id', $this->selectedDoctor->id)
                ->where('receiver_id', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
                
            $this->loadRecentChats(); // Refresh to update unread counts
        }
    }

    public function getUnreadCount($doctorId)
    {
        return ChatMessage::where('sender_id', $doctorId)
            ->where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();
    }

    public function getLastMessage($doctorId)
    {
        return ChatMessage::where(function ($query) use ($doctorId) {
                $query->where('sender_id', auth()->id())
                      ->where('receiver_id', $doctorId);
            })
            ->orWhere(function ($query) use ($doctorId) {
                $query->where('sender_id', $doctorId)
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
        return view('livewire.patient.chat');
    }
}