<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Find Pharmacy & Medicines</h1>
        <p class="text-gray-600">Search for pharmacies near you, view available medicines, and place orders</p>
    </div>

    <!-- Location Services -->
    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
        <div class="flex justify-between items-center">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-1">
                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                    </svg>
                    <h3 class="font-semibold text-blue-800">Find Pharmacies Near You</h3>
                </div>
                <p class="text-blue-600 text-sm ml-8">Allow location access to find the closest pharmacies and calculate distances</p>
            </div>
            
            @if(!$isLocationEnabled)
                <button wire:click="requestLocation" 
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        Enable Location
                    </div>
                </button>
            @else
                <div class="flex items-center gap-3">
                    <div class="text-sm text-green-700 bg-green-50 px-3 py-1.5 rounded-lg">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            Location enabled
                        </div>
                    </div>
                    <button wire:click="findNearbyPharmacies" 
                            class="bg-green-600 text-white px-5 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700 transition shadow-sm hover:shadow-md">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                            </svg>
                            Show Map
                        </div>
                    </button>
                </div>
            @endif
        </div>
    </div>

    <!-- Search Bar -->
    <div class="mb-6 relative">
        <div class="relative">
            <input type="text" wire:model.live="search" 
                   placeholder="Search pharmacies by name, address, or location..."
                   class="w-full pl-12 pr-4 py-3.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-sm">
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            @if($search)
                <button wire:click="$set('search', '')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Cart Button -->
    <div class="fixed bottom-6 right-6 z-10">
        <button wire:click="toggleCart" 
                class="bg-blue-600 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-blue-700 transition hover:shadow-xl flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            Cart ({{ $cartCount }})
            <span class="font-semibold">${{ number_format($cartTotal, 2) }}</span>
        </button>
    </div>

    <!-- Cart Sidebar -->
    @if($showCart)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-end">
        <div class="bg-white w-full max-w-md h-full shadow-xl">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">Your Cart</h3>
                    <button wire:click="toggleCart" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Cart items -->
            <div class="p-6 space-y-4 overflow-y-auto max-h-[60vh]">
                @if(count($cart) > 0)
                    @foreach($cart as $medicineId => $item)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-600">{{ $item['pharmacy_name'] }}</p>
                                    <p class="text-sm font-semibold text-blue-600 mt-1">${{ number_format($item['price'], 2) }} each</p>
                                </div>
                                <button wire:click="removeFromCart('{{ $medicineId }}')" 
                                        class="text-red-500 hover:text-red-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between mt-3">
                                <div class="flex items-center gap-2">
                                    <button wire:click="updateCartQuantity('{{ $medicineId }}', {{ $item['quantity'] - 1 }})" 
                                            class="w-8 h-8 flex items-center justify-center border rounded-lg hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <input type="number" 
                                           wire:change="updateCartQuantity('{{ $medicineId }}', $event.target.value)"
                                           value="{{ $item['quantity'] }}"
                                           min="1"
                                           max="{{ $item['max_quantity'] }}"
                                           class="w-16 text-center border rounded-lg py-1">
                                    <button wire:click="updateCartQuantity('{{ $medicineId }}', {{ $item['quantity'] + 1 }})" 
                                            class="w-8 h-8 flex items-center justify-center border rounded-lg hover:bg-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="font-semibold">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500 mt-4">Your cart is empty</p>
                    </div>
                @endif
            </div>
            
            <!-- Cart footer -->
            @if(count($cart) > 0)
                <div class="border-t p-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="font-semibold">Total:</span>
                        <span class="text-xl font-bold text-blue-600">${{ number_format($cartTotal, 2) }}</span>
                    </div>
                    
                    <!-- Delivery Options -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Option</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="$set('deliveryType', 'pickup')"
                                    class="py-2 px-4 border rounded-lg text-center {{ $deliveryType === 'pickup' ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-gray-300 text-gray-700' }}">
                                Pickup
                            </button>
                            <button wire:click="$set('deliveryType', 'delivery')"
                                    class="py-2 px-4 border rounded-lg text-center {{ $deliveryType === 'delivery' ? 'bg-blue-50 border-blue-500 text-blue-700' : 'border-gray-300 text-gray-700' }}">
                                Delivery
                            </button>
                        </div>
                    </div>
                    
                    @if($deliveryType === 'delivery')
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Address</label>
                            <textarea wire:model="deliveryAddress" 
                                      rows="2"
                                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Enter your delivery address..."></textarea>
                        </div>
                    @endif
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                        <textarea wire:model="patientNotes" 
                                  rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Any special instructions..."></textarea>
                    </div>
                    
                    <div class="space-y-2">
                        <button wire:click="checkout" 
                                class="w-full bg-green-600 text-white py-3 rounded-lg font-medium hover:bg-green-700 transition">
                            Proceed to Checkout
                        </button>
                        <button wire:click="clearCart" 
                                class="w-full border border-red-300 text-red-600 py-3 rounded-lg font-medium hover:bg-red-50 transition">
                            Clear Cart
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Leaflet Map Integration -->
    @if($showMap && $isLocationEnabled)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Nearby Pharmacies Map</h3>
            <button wire:click="hideMap" 
                    class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="pharmacy-map" class="w-full h-96 rounded-lg border border-gray-300"></div>
        <p class="text-sm text-gray-500 mt-2">Showing pharmacies within 20km radius from your location</p>
    </div>
    @endif

    <!-- Pharmacy Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($pharmacies as $pharmacy)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition duration-200">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $pharmacy->name }}</h3>
                        @if(isset($pharmacy->distance))
                            <div class="flex items-center gap-1 text-sm text-gray-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                </svg>
                                <span>{{ number_format($pharmacy->distance, 1) }} km away</span>
                            </div>
                        @endif
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                        {{ $pharmacy->is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $pharmacy->is_open ? 'Open Now' : 'Closed' }}
                    </span>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                        <span class="flex-1">{{ $pharmacy->address }}</span>
                    </div>
                    
                    @if($pharmacy->phone)
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <span>{{ $pharmacy->phone }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $pharmacy->is_24_hours ? '24 Hours Open' : ($pharmacy->opening_time && $pharmacy->closing_time ? $pharmacy->opening_time->format('h:i A') . ' - ' . $pharmacy->closing_time->format('h:i A') : 'Not specified') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-600">Available Medicines:</span>
                        <span class="text-sm font-medium text-blue-600">{{ $pharmacy->medicineStock->count() }}</span>
                    </div>
                    
                    <div class="flex gap-2">
                        <button wire:click="selectPharmacy({{ $pharmacy->id }})" 
                                class="flex-1 bg-blue-600 text-white py-2.5 px-4 rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">
                            View Medicines
                        </button>
                        <a href="https://www.openstreetmap.org/directions?from=&to={{ $pharmacy->latitude ?? 0 }},{{ $pharmacy->longitude ?? 0 }}" 
                           target="_blank"
                           class="bg-gray-100 text-gray-700 py-2.5 px-4 rounded-lg text-sm font-medium hover:bg-gray-200 transition shadow-sm flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.586 4.586a2 2 0 112.828 2.828l-3 3a2 2 0 01-2.828 0 1 1 0 00-1.414 1.414 4 4 0 005.656 0l3-3a4 4 0 00-5.656-5.656l-1.5 1.5a1 1 0 101.414 1.414l1.5-1.5zm-5 5a2 2 0 012.828 0 1 1 0 101.414-1.414 4 4 0 00-5.656 0l-3 3a4 4 0 105.656 5.656l1.5-1.5a1 1 0 10-1.414-1.414l-1.5 1.5a2 2 0 11-2.828-2.828l3-3z" clip-rule="evenodd" />
                            </svg>
                            Directions
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Selected Pharmacy Medicines Section -->
    @if($selectedPharmacy)
    <div id="pharmacy-details" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Medicines at {{ $selectedPharmacy->name }}</h3>
                <p class="text-gray-600 mt-1">{{ $selectedPharmacy->medicineStock->count() }} medicines available</p>
            </div>
            <button wire:click="$set('selectedPharmacy', null)" 
                    class="text-gray-500 hover:text-gray-700 p-2 hover:bg-gray-100 rounded-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        
        @if($selectedPharmacy->medicineStock->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($selectedPharmacy->medicineStock as $medicine)
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-blue-300 transition duration-200">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900">{{ $medicine->medicine_name }}</h4>
                                <div class="flex items-center gap-2 mt-1">
                                    @if($medicine->quantity_available > 10)
                                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded-full">In Stock</span>
                                    @elseif($medicine->quantity_available > 0)
                                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full">Low Stock</span>
                                    @else
                                        <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded-full">Out of Stock</span>
                                    @endif
                                    <span class="text-xs text-gray-500">Qty: {{ $medicine->quantity_available }}</span>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-blue-600">${{ number_format($medicine->price, 2) }}</span>
                        </div>
                        
                        @if($medicine->description)
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $medicine->description }}</p>
                        @endif
                        
                        <button wire:click="addToCart({{ $medicine->id }})" 
                                @disabled($medicine->quantity_available <= 0)
                                class="w-full py-2.5 px-4 rounded-lg text-sm font-medium transition 
                                       {{ $medicine->quantity_available > 0 ? 'bg-blue-600 text-white hover:bg-blue-700' : 'bg-gray-100 text-gray-400 cursor-not-allowed' }}
                                       shadow-sm {{ $medicine->quantity_available > 0 ? 'hover:shadow-md' : '' }}">
                            {{ $medicine->quantity_available > 0 ? 'Add to Cart' : 'Out of Stock' }}
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <svg class="w-16 h-16 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                <h4 class="mt-4 text-lg font-medium text-gray-900">No medicines available</h4>
                <p class="mt-2 text-gray-500">This pharmacy currently has no medicines in stock.</p>
            </div>
        @endif
    </div>
    @endif

    <!-- Pagination -->
    @if($pharmacies->hasPages())
        <div class="mt-8">
            {{ $pharmacies->links() }}
        </div>
    @endif
</div>

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .leaflet-container {
        z-index: 1;
    }
    .custom-div-icon {
        background: none;
        border: none;
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('livewire:init', () => {
    let map = null;
    let userMarker = null;
    let pharmacyMarkers = [];

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
                    // Show error toast using Livewire's event
                    @this.dispatch('show-toast', {
                        type: 'error',
                        message: 'Unable to get your location. Please enable location services in your browser settings.'
                    });
                },
                {
                    enableHighAccuracy: true,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        } else {
            @this.dispatch('show-toast', {
                type: 'error',
                message: 'Geolocation is not supported by your browser.'
            });
        }
    });

    // Initialize or refresh map
    Livewire.on('refresh-map', () => {
        initMap();
    });

    function initMap() {
        const mapElement = document.getElementById('pharmacy-map');
        if (!mapElement) return;

        // Remove existing map if present
        if (map) {
            map.remove();
            map = null;
        }

        // Clear markers
        if (userMarker) userMarker.remove();
        pharmacyMarkers.forEach(marker => marker.remove());
        pharmacyMarkers = [];

        const userLat = @json($userLatitude);
        const userLng = @json($userLongitude);
        
        if (!userLat || !userLng) {
            console.error('User location not available');
            return;
        }

        // Initialize map
        map = L.map('pharmacy-map').setView([userLat, userLng], 13);
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 19,
        }).addTo(map);
        
        // Add user location marker
        const userIcon = L.divIcon({
            html: `
                <div class="relative">
                    <div class="w-8 h-8 bg-blue-500 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                        <div class="w-2 h-2 bg-white rounded-full"></div>
                    </div>
                    <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 bg-blue-500 text-white text-xs px-2 py-0.5 rounded whitespace-nowrap">
                        Your Location
                    </div>
                </div>
            `,
            className: 'custom-div-icon',
            iconSize: [64, 64],
            iconAnchor: [32, 32],
            popupAnchor: [0, -32]
        });
        
        userMarker = L.marker([userLat, userLng], { icon: userIcon })
            .addTo(map)
            .bindPopup('<strong>Your Location</strong><br>This is where you are currently located.');

        // Add pharmacy markers from Livewire data
        @this.get('pharmacies').data.forEach(pharmacy => {
            if (pharmacy.latitude && pharmacy.longitude) {
                const pharmacyIcon = L.divIcon({
                    html: `
                        <div class="relative">
                            <div class="w-10 h-10 bg-red-500 rounded-full border-3 border-white shadow-lg flex items-center justify-center">
                                <div class="text-white text-xs font-bold">P</div>
                            </div>
                            <div class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 bg-red-500 text-white text-xs px-2 py-0.5 rounded whitespace-nowrap">
                                ${pharmacy.name.length > 15 ? pharmacy.name.substring(0, 15) + '...' : pharmacy.name}
                            </div>
                        </div>
                    `,
                    className: 'custom-div-icon',
                    iconSize: [80, 80],
                    iconAnchor: [40, 40],
                    popupAnchor: [0, -40]
                });
                
                const marker = L.marker([pharmacy.latitude, pharmacy.longitude], { icon: pharmacyIcon })
                    .addTo(map)
                    .bindPopup(`
                        <div class="p-2">
                            <strong class="text-lg">${pharmacy.name}</strong>
                            <p class="text-sm text-gray-600 mt-1">${pharmacy.address}</p>
                            <div class="mt-2 space-y-1">
                                ${pharmacy.phone ? `<p class="text-sm"><strong>Phone:</strong> ${pharmacy.phone}</p>` : ''}
                                <p class="text-sm"><strong>Status:</strong> <span class="${pharmacy.is_open ? 'text-green-600' : 'text-red-600'}">${pharmacy.is_open ? 'Open' : 'Closed'}</span></p>
                                ${pharmacy.distance ? `<p class="text-sm"><strong>Distance:</strong> ${pharmacy.distance.toFixed(1)} km</p>` : ''}
                            </div>
                            <div class="mt-3 flex gap-2">
                                <button onclick="window.Livewire.dispatch('selectPharmacy', {pharmacyId: ${pharmacy.id}})" 
                                        class="px-3 py-1 bg-blue-500 text-white text-sm rounded hover:bg-blue-600 transition">
                                    View Medicines
                                </button>
                                <a href="https://www.openstreetmap.org/directions?from=&to=${pharmacy.latitude},${pharmacy.longitude}" 
                                   target="_blank"
                                   class="px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded hover:bg-gray-200 transition">
                                    Directions
                                </a>
                            </div>
                        </div>
                    `);
                
                pharmacyMarkers.push(marker);
            }
        });

        // Fit bounds to show all markers
        if (pharmacyMarkers.length > 0) {
            const group = new L.FeatureGroup([userMarker, ...pharmacyMarkers]);
            map.fitBounds(group.getBounds().pad(0.1));
        }

        // Add click event to recenter on user location
        map.on('click', function(e) {
            userMarker.setLatLng(e.latlng);
            @this.setUserLocation(e.latlng.lat, e.latlng.lng);
        });
    }

    // Scroll to pharmacy details when selected
    Livewire.on('scroll-to-pharmacy-details', () => {
        const element = document.getElementById('pharmacy-details');
        if (element) {
            element.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });

    // Initialize map if shown on page load
    @if($showMap && $userLatitude && $userLongitude)
        setTimeout(initMap, 500); // Small delay to ensure DOM is ready
    @endif
});
</script>
@endpush