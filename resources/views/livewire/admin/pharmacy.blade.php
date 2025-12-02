<div class="p-6">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Pharmacy Management</h1>

    <!-- Search and Add New Pharmacy -->
    <div class="flex justify-between items-center mb-6">
        <div class="w-64">
            <input type="text" wire:model.live="search" 
                   placeholder="Search pharmacies..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>
        <button wire:click="$toggle('showAddPharmacyForm')"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Add New Pharmacy
        </button>
    </div>

    <!-- Add Pharmacy Form -->
    @if($showAddPharmacyForm)
    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 mb-6">
        <h3 class="text-lg font-semibold mb-4">Add New Pharmacy</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Pharmacy Name</label>
                <input type="text" wire:model="newPharmacyName" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('newPharmacyName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                <input type="text" wire:model="newPharmacyPhone" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('newPharmacyPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                <textarea wire:model="newPharmacyAddress" rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
                @error('newPharmacyAddress') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Latitude</label>
                <input type="number" step="any" wire:model="newPharmacyLatitude" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('newPharmacyLatitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Longitude</label>
                <input type="number" step="any" wire:model="newPharmacyLongitude" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                @error('newPharmacyLongitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>
        <div class="flex justify-end gap-3 mt-4">
            <button wire:click="$set('showAddPharmacyForm', false)"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Cancel
            </button>
            <button wire:click="addNewPharmacy"
                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Save Pharmacy
            </button>
        </div>
    </div>
    @endif

    <!-- Pharmacy List -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @foreach($pharmacies as $pharmacy)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $pharmacy->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ $pharmacy->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($pharmacy->status) }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                {{ $pharmacy->is_open ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $pharmacy->is_open ? 'Open' : 'Closed' }}
                            </span>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="togglePharmacyStatus({{ $pharmacy->id }})"
                                class="text-sm {{ $pharmacy->status === 'approved' ? 'text-yellow-600' : 'text-green-600' }}">
                            {{ $pharmacy->status === 'approved' ? 'Disable' : 'Approve' }}
                        </button>
                        <button wire:click="deletePharmacy({{ $pharmacy->id }})"
                                class="text-sm text-red-600">
                            Delete
                        </button>
                    </div>
                </div>
                
                <div class="space-y-2 text-sm text-gray-600 mb-4">
                    <p>{{ $pharmacy->address }}</p>
                    <p>{{ $pharmacy->phone }}</p>
                    <p>Location: {{ number_format($pharmacy->latitude, 4) }}, {{ number_format($pharmacy->longitude, 4) }}</p>
                </div>

                <div class="flex gap-2">
                    <button wire:click="selectPharmacy({{ $pharmacy->id }})" 
                            class="flex-1 bg-blue-600 text-white py-2 px-4 rounded-lg text-sm hover:bg-blue-700">
                        Manage Medicines
                    </button>
                    <button wire:click="viewOrders({{ $pharmacy->id }})" 
                            class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg text-sm hover:bg-gray-200">
                        View Orders
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pharmacies->links() }}
    </div>

    <!-- Selected Pharmacy Medicines Management -->
    @if($selectedPharmacy)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Manage Medicines - {{ $selectedPharmacy->name }}</h3>
                <p class="text-gray-600">Add, update, or remove medicines from this pharmacy</p>
            </div>
            <button wire:click="$set('selectedPharmacy', null)" 
                    class="text-gray-500 hover:text-gray-700">
                ✕ Close
            </button>
        </div>

        <!-- Add Medicine Form -->
        <div class="bg-gray-50 p-4 rounded-lg mb-6">
            <h4 class="font-semibold mb-4">Add New Medicine</h4>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" wire:model="medicineName" 
                           placeholder="Medicine Name"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <input type="number" step="0.01" wire:model="medicinePrice" 
                           placeholder="Price"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <input type="number" wire:model="medicineQuantity" 
                           placeholder="Quantity"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg">
                </div>
                <div>
                    <button wire:click="addMedicine" 
                            class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700">
                        Add Medicine
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <textarea wire:model="medicineDescription" 
                          placeholder="Description (optional)"
                          rows="2"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg"></textarea>
            </div>
        </div>

        <!-- Medicines List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Medicine</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($selectedPharmacy->medicineStock as $medicine)
                        <tr>
                            <td class="px-6 py-4">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $medicine->medicine_name }}</div>
                                    @if($medicine->description)
                                        <div class="text-sm text-gray-500">{{ $medicine->description }}</div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium">${{ number_format($medicine->price, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <input type="number" 
                                       wire:change="updateMedicineStock({{ $medicine->id }}, $event.target.value)"
                                       value="{{ $medicine->quantity_available }}"
                                       class="w-24 px-2 py-1 border border-gray-300 rounded">
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="deleteMedicine({{ $medicine->id }})"
                                        class="text-red-600 hover:text-red-900 text-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Orders Modal -->
    @if($showOrders)
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold">Pharmacy Orders</h3>
                    <button wire:click="$set('showOrders', false)" 
                            class="text-gray-500 hover:text-gray-700">
                        ✕
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto max-h-[70vh]">
                @if($orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-4">
                                <div class="flex justify-between items-start mb-3">
                                    <div>
                                        <div class="font-semibold">Order #{{ $order->order_number }}</div>
                                        <div class="text-sm text-gray-600">
                                            Customer: {{ $order->user->name ?? 'N/A' }}<br>
                                            Date: {{ $order->created_at->format('M d, Y h:i A') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                               ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <div class="font-bold mt-1">${{ number_format($order->total_amount, 2) }}</div>
                                    </div>
                                </div>
                                
                                <!-- Order Items -->
                                <div class="border-t pt-3 mt-3">
                                    <div class="text-sm font-medium mb-2">Order Items:</div>
                                    @foreach($order->items as $item)
                                        <div class="flex justify-between text-sm">
                                            <span>{{ $item->medicine->medicine_name ?? 'Unknown' }} × {{ $item->quantity }}</span>
                                            <span>${{ number_format($item->total_price, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Order Actions -->
                                <div class="flex justify-between items-center mt-4 pt-4 border-t">
                                    <div class="text-sm text-gray-600">
                                        {{ ucfirst($order->delivery_type) }} • 
                                        Payment: {{ ucfirst($order->payment_status) }}
                                    </div>
                                    <div class="flex gap-2">
                                        <select wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)"
                                                class="text-sm border rounded px-2 py-1">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-lg">No orders found</div>
                        <p class="text-gray-500 mt-2">This pharmacy hasn't received any orders yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>