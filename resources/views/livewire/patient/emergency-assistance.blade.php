<div class="p-8">
    <div class="flex flex-col gap-8">
        <!-- Page Heading -->
        <div class="flex flex-col gap-1">
            <p class="text-text-light-primary dark:text-text-dark-primary text-3xl font-bold tracking-tight">
                Emergency Assistance
            </p>
            <p class="text-text-light-secondary dark:text-text-dark-secondary text-base font-normal">
                Quick access to emergency services and important contacts
            </p>
        </div>

        <!-- Emergency Hotlines Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Emergency Hotlines Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        <span class="material-symbols-outlined align-middle mr-2 text-red-500">emergency</span>
                        Emergency Hotlines
                    </h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-red-100 dark:bg-red-900 text-red-600 dark:text-red-300 font-semibold">24/7</span>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach(array_slice($this->emergencyServices, 0, 3) as $service)
                    <div class="emergency-item group" 
                         data-service="{{ $service['name'] }}" 
                         data-number="{{ $service['number'] }}" 
                         data-description="{{ $service['description'] }}">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark hover:bg-{{ $service['color'] }}-50 dark:hover:bg-{{ $service['color'] }}-900/20 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-{{ $service['color'] }}-100 dark:bg-{{ $service['color'] }}-900 group-hover:bg-{{ $service['color'] }}-200 dark:group-hover:bg-{{ $service['color'] }}-800 transition-colors duration-200">
                                    <span class="material-symbols-outlined text-{{ $service['color'] }}-500 dark:text-{{ $service['color'] }}-300">{{ $service['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $service['name'] }}</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $service['description'] }}</p>
                                </div>
                            </div>
                            <button wire:click="confirmCall('{{ $service['number'] }}', '{{ $service['name'] }}', '{{ $service['description'] }}')" 
                                    class="call-btn flex items-center justify-center rounded-lg h-12 px-5 bg-{{ $service['button_color'] }}-500 hover:bg-{{ $service['button_color'] }}-600 text-white text-sm font-bold gap-2 transition-all duration-200 active:scale-95">
                                <span class="material-symbols-outlined">call</span>
                                <span>{{ $service['number'] }}</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Medical Helplines Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        <span class="material-symbols-outlined align-middle mr-2 text-blue-500">local_hospital</span>
                        Medical Helplines
                    </h2>
                    <span class="text-xs px-3 py-1 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 font-semibold">Medical</span>
                </div>
                
                <div class="flex flex-col gap-4">
                    @foreach(array_slice($this->emergencyServices, 3) as $service)
                    <div class="emergency-item group" 
                         data-service="{{ $service['name'] }}" 
                         data-number="{{ $service['number'] }}" 
                         data-description="{{ $service['description'] }}">
                        <div class="flex items-center justify-between p-4 rounded-lg bg-background-light dark:bg-background-dark hover:bg-{{ $service['color'] }}-50 dark:hover:bg-{{ $service['color'] }}-900/20 transition-colors duration-200">
                            <div class="flex items-center gap-3">
                                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-{{ $service['color'] }}-100 dark:bg-{{ $service['color'] }}-900 group-hover:bg-{{ $service['color'] }}-200 dark:group-hover:bg-{{ $service['color'] }}-800 transition-colors duration-200">
                                    <span class="material-symbols-outlined text-{{ $service['color'] }}-500 dark:text-{{ $service['color'] }}-300">{{ $service['icon'] }}</span>
                                </div>
                                <div>
                                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $service['name'] }}</p>
                                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $service['description'] }}</p>
                                </div>
                            </div>
                            <button wire:click="confirmCall('{{ $service['number'] }}', '{{ $service['name'] }}', '{{ $service['description'] }}')" 
                                    class="call-btn flex items-center justify-center rounded-lg h-12 px-5 bg-{{ $service['button_color'] }}-500 hover:bg-{{ $service['button_color'] }}-600 text-white text-sm font-bold gap-2 transition-all duration-200 active:scale-95">
                                <span class="material-symbols-outlined">call</span>
                                <span>{{ str_contains($service['number'], '+94') ? 'Call Now' : $service['number'] }}</span>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if($showNotification)
        <!-- Call Notification -->
        <div id="call-notification" class="fixed bottom-4 right-4 z-50 animate__animated animate__fadeInUp">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl p-6 w-96 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-900">
                            <span class="material-symbols-outlined text-red-500 dark:text-red-300">call</span>
                        </div>
                        <div>
                            <h3 class="text-text-light-primary dark:text-text-dark-primary font-bold">{{ $notificationService }}</h3>
                            <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Calling: {{ $notificationNumber }}</p>
                        </div>
                    </div>
                    <button wire:click="closeNotification" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="mb-4">
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">Call in progress to:</p>
                    <p class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $notificationDescription }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="tel:{{ $notificationNumber }}" 
                       class="flex-1 flex items-center justify-center rounded-lg h-12 bg-red-500 hover:bg-red-600 text-white font-bold gap-2"
                       onclick="logEmergencyCall('{{ $notificationService }}', '{{ $notificationNumber }}')">
                        <span class="material-symbols-outlined">call</span>
                        Dial Now
                    </a>
                    <button wire:click="closeNotification" 
                            class="flex-1 flex items-center justify-center rounded-lg h-12 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-bold">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
        @endif

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Share Location Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex flex-col items-center text-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-red-100 dark:bg-red-900 mb-4">
                        <span class="material-symbols-outlined text-red-500 dark:text-red-300 text-3xl">location_on</span>
                    </div>
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-2">
                        Share Location
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-6">
                        Share your current location with emergency services
                    </p>
                    <button wire:click="shareLocation" 
                            x-data
                            x-on:click="shareUserLocation()"
                            class="flex w-full items-center justify-center rounded-lg h-12 px-4 bg-red-500 hover:bg-red-600 text-white text-sm font-bold gap-2">
                        <span class="material-symbols-outlined">share_location</span>
                        Share Location
                    </button>
                </div>
            </div>

            <!-- Nearest Hospital Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex flex-col items-center text-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-orange-100 dark:bg-orange-900 mb-4">
                        <span class="material-symbols-outlined text-orange-500 dark:text-orange-300 text-3xl">local_hospital</span>
                    </div>
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-2">
                        Nearest Hospital
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-6">
                        Find the closest hospital to your location
                    </p>
                    <button wire:click="findNearestHospital" 
                            x-data
                            x-on:click="findHospitalNearby()"
                            class="flex w-full items-center justify-center rounded-lg h-12 px-4 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold gap-2">
                        <span class="material-symbols-outlined">search</span>
                        Find Hospital
                    </button>
                </div>
            </div>

            <!-- Emergency Contact Card -->
            <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
                <div class="flex flex-col items-center text-center">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 dark:bg-blue-900 mb-4">
                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300 text-3xl">medical_services</span>
                    </div>
                    <h3 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold mb-2">
                        Emergency Contact
                    </h3>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm mb-6">
                        Contact your assigned emergency contact
                    </p>
                    <button wire:click="contactEmergency" 
                            class="flex w-full items-center justify-center rounded-lg h-12 px-4 bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold gap-2">
                        <span class="material-symbols-outlined">contacts</span>
                        Contact Now
                    </button>
                </div>
            </div>
        </div>

        <!-- Emergency Guidelines -->
        <div class="bg-card-light dark:bg-card-dark p-6 rounded-xl border border-border-light dark:border-border-dark">
            <div class="flex items-center gap-3 mb-6">
                <div class="flex items-center justify-center w-12 h-12 rounded-lg bg-blue-100 dark:bg-blue-900">
                    <span class="material-symbols-outlined text-blue-500 dark:text-blue-300">info</span>
                </div>
                <div>
                    <h2 class="text-text-light-primary dark:text-text-dark-primary text-lg font-bold">
                        Emergency Guidelines
                    </h2>
                    <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">
                        Important information for emergency situations
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-red-500">warning</span>
                        <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                            When to Call Emergency Services:
                        </h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach(array_slice($this->emergencyGuidelines['when_to_call'], 0, 4) as $guideline)
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-green-500 text-sm mt-0.5">check_circle</span>
                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $guideline }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-blue-500">info</span>
                        <h3 class="text-text-light-primary dark:text-text-dark-primary font-semibold">
                            What to Tell Emergency Dispatcher:
                        </h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach(array_slice($this->emergencyGuidelines['what_to_tell'], 0, 4) as $guideline)
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-green-500 text-sm mt-0.5">check_circle</span>
                            <span class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $guideline }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @if($showStatus)
    <!-- Status Notification -->
    <div class="fixed top-4 right-4 z-50 animate__animated animate__fadeInDown">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-4 w-80 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900">
                        <span class="material-symbols-outlined text-blue-500 dark:text-blue-300 text-sm">info</span>
                    </div>
                    <div>
                        <h4 class="text-text-light-primary dark:text-text-dark-primary font-semibold">{{ $statusTitle }}</h4>
                        <p class="text-text-light-secondary dark:text-text-dark-secondary text-sm">{{ $statusMessage }}</p>
                    </div>
                </div>
                <button wire:click="closeStatus" class="text-gray-400 hover:text-gray-600">
                    <span class="material-symbols-outlined text-sm">close</span>
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Alpine.js and JavaScript for location services -->
    <script>
        // Function to share user location
        function shareUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const location = {
                            latitude: position.coords.latitude,
                            longitude: position.coords.longitude,
                            accuracy: position.coords.accuracy
                        };
                        
                        // Copy location to clipboard
                        const locationText = `Latitude: ${location.latitude}, Longitude: ${location.longitude}`;
                        navigator.clipboard.writeText(locationText).then(() => {
                            console.log('Location copied to clipboard');
                        });
                        
                        // Dispatch to Livewire
                        @this.dispatch('location-shared', location);
                        
                        // Open Google Maps with location
                        const mapsUrl = `https://www.google.com/maps?q=${location.latitude},${location.longitude}`;
                        window.open(mapsUrl, '_blank');
                    },
                    function(error) {
                        let errorMessage = 'Unable to retrieve your location. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Permission denied. Please enable location services.';
                                break;
                            case error.POSITION_UNAVAILABLE:
                                errorMessage += 'Location information is unavailable.';
                                break;
                            case error.TIMEOUT:
                                errorMessage += 'Location request timed out.';
                                break;
                            default:
                                errorMessage += 'An unknown error occurred.';
                                break;
                        }
                        @this.dispatch('location-error', [errorMessage]);
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                @this.dispatch('location-error', 'Geolocation is not supported by this browser.');
            }
        }

        // Function to find nearest hospital
        function findHospitalNearby() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        // Open Google Maps with hospital search
                        const mapsUrl = `https://www.google.com/maps/search/hospital/@${lat},${lng},15z`;
                        window.open(mapsUrl, '_blank');
                        
                        // Dispatch to Livewire
                        @this.dispatch('hospital-found', {
                            latitude: lat,
                            longitude: lng,
                            count: 'multiple',
                            timestamp: new Date().toISOString()
                        });
                    },
                    function(error) {
                        let errorMessage = 'Unable to find hospitals. ';
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                errorMessage += 'Location permission denied.';
                                break;
                            default:
                                errorMessage += 'Could not get your location.';
                                break;
                        }
                        @this.dispatch('location-error', [errorMessage]);
                    }
                );
            } else {
                // Fallback: Open general hospital search
                window.open('https://www.google.com/maps/search/hospital', '_blank');
                @this.dispatch('hospital-found', {
                    count: 'multiple',
                    timestamp: new Date().toISOString(),
                    note: 'Using general search (no location)'
                });
            }
        }

        // Function to log emergency calls
        function logEmergencyCall(service, number) {
            // Add visual feedback
            const callBtn = event.target.closest('a');
            if (callBtn) {
                callBtn.classList.add('animate-pulse');
                setTimeout(() => callBtn.classList.remove('animate-pulse'), 1000);
            }
            
            // Play sound if available
            playCallSound();
            
            // Vibrate if supported
            if (navigator.vibrate) {
                navigator.vibrate([100, 50, 100]);
            }
            
            console.log(`Initiating call to ${service}: ${number}`);
        }

        // Function to play call sound
        function playCallSound() {
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
            } catch (e) {
                // Audio not supported, continue silently
            }
        }

        // Close notification when clicking outside
        document.addEventListener('click', function(event) {
            const notification = document.getElementById('call-notification');
            if (notification && !notification.contains(event.target) && 
                !event.target.closest('.call-btn')) {
                @this.call('closeNotification');
            }
        });

        // Auto-hide status notification after 5 seconds
        document.addEventListener('livewire:initialized', () => {
            @this.on('hide-status', () => {
                setTimeout(() => {
                    @this.call('closeStatus');
                }, 5000);
            });
        });
    </script>

    <style>
        .call-btn:active {
            transform: scale(0.95);
        }
        
        .emergency-item:hover {
            cursor: pointer;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .animate-pulse {
            animation: pulse 0.5s ease-in-out;
        }
    </style>
</div>