<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.patient')]
class EmergencyAssistance extends Component
{
    public $showNotification = false;
    public $notificationService = '';
    public $notificationNumber = '';
    public $notificationDescription = '';
    
    public $showStatus = false;
    public $statusTitle = '';
    public $statusMessage = '';
    
    // Emergency services data
    public $emergencyServices = [
        [
            'name' => 'Ambulance Service',
            'number' => '1990',
            'description' => '24/7 Emergency Medical Service',
            'icon' => 'phone_in_talk',
            'color' => 'red',
            'button_color' => 'red',
        ],
        [
            'name' => 'Police Emergency',
            'number' => '119',
            'description' => '24/7 Police Service',
            'icon' => 'local_police',
            'color' => 'gray',
            'button_color' => 'gray',
        ],
        [
            'name' => 'Fire & Rescue',
            'number' => '110',
            'description' => '24/7 Fire Emergency',
            'icon' => 'fire_truck',
            'color' => 'orange',
            'button_color' => 'orange',
        ],
        [
            'name' => 'CareBridge 24/7 Helpline',
            'number' => '+94112345678',
            'description' => 'Our dedicated medical support',
            'icon' => 'support_agent',
            'color' => 'blue',
            'button_color' => 'blue',
        ],
        [
            'name' => 'Poison Information Centre',
            'number' => '0112691111',
            'description' => 'Toxicology Emergency',
            'icon' => 'science',
            'color' => 'green',
            'button_color' => 'green',
        ],
        [
            'name' => 'Mental Health Crisis Line',
            'number' => '1926',
            'description' => '24/7 Psychological Support',
            'icon' => 'psychology',
            'color' => 'indigo',
            'button_color' => 'indigo',
        ],
    ];
    
    // Emergency guidelines
    public $emergencyGuidelines = [
        'when_to_call' => [
            'Severe chest pain or difficulty breathing',
            'Uncontrolled bleeding or severe injuries',
            'Loss of consciousness or seizures',
            'Severe allergic reactions',
            'Signs of stroke (FAST: Face, Arms, Speech, Time)',
            'Severe burns or poisoning',
        ],
        'what_to_tell' => [
            'Your exact location and contact number',
            'Nature of the emergency',
            'Number of people needing help',
            'Condition of the patient(s)',
            'Any immediate dangers present',
            'Follow dispatcher\'s instructions',
        ],
    ];
    
    public function confirmCall($number, $service, $description = '')
    {
        $this->notificationService = $service;
        $this->notificationNumber = $number;
        $this->notificationDescription = $description ?: $this->getServiceDescription($service);
        $this->showNotification = true;
        
        // Log the emergency call attempt
        $this->logEmergencyCall($service, $number);
        
        // Dispatch browser event for sound/vibration (optional)
        $this->dispatch('emergency-call-initiated', 
            service: $service,
            number: $number
        );
    }
    
    private function getServiceDescription($service)
    {
        foreach ($this->emergencyServices as $serviceData) {
            if ($serviceData['name'] === $service) {
                return $serviceData['description'];
            }
        }
        return $service;
    }
    
    public function closeNotification()
    {
        $this->showNotification = false;
    }
    
    public function shareLocation()
    {
        if ($this->hasGeolocationSupport()) {
            $this->showStatusNotification(
                'Location Sharing', 
                'Preparing to share your location with emergency services...'
            );
            
            // Dispatch browser event to get location
            $this->dispatch('get-user-location');
        } else {
            $this->showStatusNotification(
                'Location Error', 
                'Geolocation is not supported by your browser. Please enable location services.'
            );
        }
    }
    
    public function findNearestHospital()
    {
        if ($this->hasGeolocationSupport()) {
            $this->showStatusNotification(
                'Finding Hospitals', 
                'Searching for nearest hospitals...'
            );
            
            // Dispatch browser event to open maps
            $this->dispatch('find-nearest-hospital');
        } else {
            $this->showStatusNotification(
                'Location Error', 
                'Geolocation is not supported by your browser. Please enable location services.'
            );
        }
    }
    
    public function contactEmergency()
    {
        // Get user's emergency contact from database if available
        $emergencyContact = auth()->user()->emergency_contact ?? null;
        
        if ($emergencyContact) {
            $this->confirmCall(
                $emergencyContact->phone_number,
                'Emergency Contact: ' . $emergencyContact->name,
                'Your saved emergency contact'
            );
        } else {
            $this->showStatusNotification(
                'Emergency Contact', 
                'No emergency contact saved. Please call CareBridge Helpline: +94 11 234 5678'
            );
        }
    }
    
    private function hasGeolocationSupport()
    {
        // This would be checked via JavaScript
        // For now, return true and handle in frontend
        return true;
    }
    
    public function showStatusNotification($title, $message)
    {
        $this->statusTitle = $title;
        $this->statusMessage = $message;
        $this->showStatus = true;
        
        // Auto-hide after 5 seconds (handled in frontend JS)
        $this->dispatch('hide-status');
    }
    
    public function closeStatus()
    {
        $this->showStatus = false;
    }
    
    private function logEmergencyCall($service, $number)
    {
        // Save to database if needed
        // For example: EmergencyCallLog::create([...]);
        
        // Or just log it
        \Log::info('Emergency call attempted', [
            'service' => $service,
            'number' => $number,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'timestamp' => now()->toDateTimeString(),
        ]);
    }
    
    // Listen for browser events
    protected $listeners = [
        'hide-status' => 'closeStatus',
        'location-shared' => 'handleLocationShared',
        'location-error' => 'handleLocationError',
        'hospital-found' => 'handleHospitalFound',
    ];
    
    public function handleLocationShared($location = null)
    {
        if (empty($location) || !isset($location['latitude'], $location['longitude'])) {
            $this->showStatusNotification(
                'Location Shared',
                'Location shared event received.'
            );
            return;
        }

        $this->showStatusNotification(
            'Location Shared Successfully',
            'Your location has been shared with emergency services. Latitude: ' . 
            number_format($location['latitude'], 4) . ', Longitude: ' . 
            number_format($location['longitude'], 4)
        );
        
        // In a real app, you would save this location to database
        // or send to emergency services API
    }
    
    public function handleLocationError($error = null)
    {
        $message = is_string($error) ? $error : 'Unable to get your location.';
        $this->showStatusNotification(
            'Location Error',
            $message
        );
    }
    
    public function handleHospitalFound($results = null)
    {
        if (empty($results) || !isset($results['count'])) {
            $this->showStatusNotification(
                'Hospitals Found',
                'Hospitals found event received.'
            );
            return;
        }

        $this->showStatusNotification(
            'Hospitals Found',
            'Found ' . $results['count'] . ' hospitals near you. Opening in maps...'
        );
    }
    
    public function render()
    {
        return view('livewire.patient.emergency-assistance');
    }
}