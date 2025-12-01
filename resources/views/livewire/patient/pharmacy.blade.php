<div class="p-6">
    <h1 class="text-2xl font-semibold mb-6">Find Pharmacy & Medicines</h1>

    <!-- Location Services -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="font-semibold text-blue-800">Find Pharmacies Near You</h3>
                <p class="text-blue-600 text-sm">Allow location access to find the closest pharmacies</p>
            </div>
            @if(!$userLocation)
                <button wire:click="requestLocation" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                    Enable Location
                </button>
            @else
                <button wire:click="findNearbyPharmacies" 
                        class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition">
                    Show Nearby Pharmacies
                </button>
            @endif
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <input type="text" wire:model.live="search" 
               placeholder="Search pharmacies by name or location..."
               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
    </div>

    <!-- Google Maps Integration -->
    @if($showMap && $userLocation)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4">Nearby Pharmacies Map</h3>
        <div id="pharmacy-map" class="w-full h-64 rounded-lg border border-gray-300"></div>
    </div>
    @endif

    <!-- Pharmacy Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($pharmacies as $pharmacy)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $pharmacy->name }}</h3>
                    <div class="flex flex-col items-end gap-1">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                            {{ $pharmacy->is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $pharmacy->is_open ? 'Open' : 'Closed' }}
                        </span>
                        @if(isset($pharmacy->distance))
                            <span class="text-xs text-gray-500">{{ number_format($pharmacy->distance, 1) }} km away</span>
                        @endif
                    </div>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <p class="flex items-center">
                        <span class="material-symbols-outlined text-base mr-2">location_on</span>
                        {{ $pharmacy->address }}
                    </p>
                    <p class="flex items-center">
                        <span class="material-symbols-outlined text-base mr-2">call</span>
                        {{ $pharmacy->phone }}
                    </p>
                    <p class="flex items-center">
                        <span class="material-symbols-outlined text-base mr-2">schedule</span>
                        {{ $pharmacy->is_24_hours ? '24 Hours' : $pharmacy->opening_time . ' - ' . $pharmacy->closing_time }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <button wire:click="selectPharmacy({{ $pharmacy->id }})" 
                            class="flex-1 bg-primary text-white py-2 px-4 rounded-lg text-sm font-medium hover:bg-primary-dark transition">
                        View Medicines
                    </button>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $pharmacy->latitude }},{{ $pharmacy->longitude }}" 
                       target="_blank"
                       class="bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm font-medium hover:bg-gray-200 transition flex items-center">
                        <span class="material-symbols-outlined text-base mr-1">directions</span>
                        Directions
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Selected Pharmacy Medicines Section (keep existing) -->
    @if($selectedPharmacy)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <!-- ... existing medicine selection code ... -->
    </div>
    @endif

    <!-- Cart Section (keep existing) -->
    <!-- ... existing cart code ... -->
</div>

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"></script>
<script>
document.addEventListener('livewire:init', () => {
    // Request user location
    Livewire.on('request-user-location', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    @this.setUserLocation(lat, lng);
                },
                (error) => {
                    console.error('Geolocation error:', error);
                    alert('Unable to get your location. Please enable location services.');
                }
            );
        } else {
            alert('Geolocation is not supported by this browser.');
        }
    });

    // Initialize Google Maps
    @if($showMap && $userLocation)
    initMap();
    @endif

    function initMap() {
        const userLocation = { lat: @json($userLatitude), lng: @json($userLongitude) };
        
        const map = new google.maps.Map(document.getElementById('pharmacy-map'), {
            zoom: 12,
            center: userLocation,
        });

        // Add user location marker
        new google.maps.Marker({
            position: userLocation,
            map: map,
            title: 'Your Location',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
            }
        });

        // Add pharmacy markers
        @foreach($pharmacies as $pharmacy)
            new google.maps.Marker({
                position: { lat: {{ $pharmacy->latitude }}, lng: {{ $pharmacy->longitude }} },
                map: map,
                title: '{{ $pharmacy->name }}',
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
                }
            });
        @endforeach
    }
});
</script>
@endpush