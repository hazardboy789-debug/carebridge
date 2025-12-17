<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.doctor')]
class Chat extends Component
{
    use WithFileUploads;

    protected $listeners = ['prescriptionCreated' => 'onPrescriptionCreated'];

    public $patients = [];
    public $selectedPatient = null;
    public $messages = [];
    public $newMessage = '';
    public $fileUpload;
    
    // Prescription related properties
    public $showPrescriptionDetails = false;
    public $selectedPrescription;

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

            // Build array of stdClass objects so Livewire can serialize safely
            $this->patients = $users->map(function($user) {
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
                    $lastMessage->created_at = $lastMessageModel->created_at;
                    $lastMessage->read_at = $lastMessageModel->read_at;
                }

                $patient = new \stdClass();
                $patient->id = $user->id;
                $patient->name = $user->name;
                $patient->email = $user->email;
                $patient->last_message = $lastMessage;
                $patient->unread_count = $unreadCount;
                $patient->last_activity = $lastMessage ? $lastMessage->created_at : now()->subYears(10);

                return $patient;
            })->sortByDesc(function($p) { return $p->last_activity; })->values()->all();

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
            $this->dispatch('messageSent'); // Trigger auto-scroll
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
            $messages = ChatMessage::where(function ($query) {
                    $query->where('sender_id', auth()->id())
                          ->where('receiver_id', $this->selectedPatient->id);
                })
                ->orWhere(function ($query) {
                    $query->where('sender_id', $this->selectedPatient->id)
                          ->where('receiver_id', auth()->id());
                })
                ->orderBy('created_at', 'asc')
                ->get();

            // Convert message models to stdClass objects preserving Carbon dates
            $this->messages = $messages->map(function($m) {
                $o = new \stdClass();
                $o->id = $m->id;
                $o->sender_id = $m->sender_id;
                $o->receiver_id = $m->receiver_id;
                $o->message = $m->message;
                $o->message_type = $m->message_type;
                $o->file_path = $m->file_path;
                $o->file_size = $m->file_size ?? null;
                $o->metadata = $m->metadata;
                $o->created_at = $m->created_at;
                $o->read_at = $m->read_at;
                return $o;
            })->all();

            \Log::info('Loaded messages: ' . count($this->messages));

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
                
                // Store file size for display
                $messageData['file_size'] = $this->fileUpload->getSize();
            } else {
                // Validate text message
                $this->validate([
                    'newMessage' => 'required|string|min:1',
                ]);

                $messageData['message'] = trim($this->newMessage);
                $messageData['message_type'] = 'text';
                $messageData['file_size'] = null;
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
        } elseif ($mimeType === 'application/pdf') {
            return 'prescription';
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

    // Prescription Methods
    public function sendPrescriptionAsMessage($prescriptionId)
    {
        try {
            $prescription = Prescription::findOrFail($prescriptionId);
            
            // Check if doctor has permission to send this prescription
            if ($prescription->doctor_id !== auth()->id()) {
                session()->flash('error', 'You do not have permission to send this prescription.');
                return;
            }

            if (!$prescription->file_path) {
                session()->flash('error', 'Prescription PDF not found.');
                return;
            }

            // Send prescription as a prescription message
            $messageData = [
                'sender_id' => auth()->id(),
                'receiver_id' => $this->selectedPatient->id,
                'message' => "📋 Prescription for " . $this->selectedPatient->name,
                'message_type' => 'prescription',
                'file_path' => $prescription->file_path,
                'file_size' => Storage::disk('public')->exists($prescription->file_path) 
                    ? Storage::disk('public')->size($prescription->file_path) 
                    : 0,
                'metadata' => json_encode([
                    'type' => 'prescription',
                    'prescription_id' => $prescription->id,
                    'diagnosis' => $prescription->diagnosis,
                    'follow_up_date' => $prescription->follow_up_date,
                ])
            ];

            ChatMessage::create($messageData);
            
            // Update prescription status
            $prescription->update(['status' => 'sent']);
            
            // Refresh messages
            $this->loadMessages();
            $this->loadRecentChats();
            
            // Dispatch event for auto-scroll
            $this->dispatch('messageSent');
            
            session()->flash('success', 'Prescription sent successfully!');

        } catch (\Exception $e) {
            Log::error('Error sending prescription: ' . $e->getMessage());
            session()->flash('error', 'Failed to send prescription. Please try again.');
        }
    }

    public function viewPrescription($prescriptionId)
    {
        try {
            $this->selectedPrescription = Prescription::with(['patient', 'doctor'])
                ->findOrFail($prescriptionId);
            
            // Check if the doctor can view this prescription
            if ($this->selectedPrescription->doctor_id !== auth()->id()) {
                session()->flash('error', 'You do not have permission to view this prescription.');
                return;
            }
            
            $this->showPrescriptionDetails = true;
            
            // Dispatch event to close any other modals
            $this->dispatch('close-prescription-modal');
            
        } catch (\Exception $e) {
            Log::error('Error viewing prescription: ' . $e->getMessage());
            session()->flash('error', 'Prescription not found.');
        }
    }

    public function closePrescriptionDetails()
    {
        $this->showPrescriptionDetails = false;
        $this->selectedPrescription = null;
    }

    // Method to handle prescription creation from modal
    public function onPrescriptionCreated($prescriptionId)
    {
        // Refresh recent chats and messages when a prescription is created
        $prescription = Prescription::find($prescriptionId);
        $this->loadRecentChats();
        if ($this->selectedPatient && $prescription && $prescription->patient_id === $this->selectedPatient->id) {
            $this->loadMessages();
            $this->dispatch('messageSent');
        }
    }

    public function render()
    {
        return view('livewire.doctor.chat');
    }
}