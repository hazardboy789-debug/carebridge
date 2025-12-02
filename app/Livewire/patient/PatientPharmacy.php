<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Pharmacy;
use App\Models\MedicineStock;
use App\Models\PharmacyOrder;

#[Layout('components.layouts.patient')]
class PatientPharmacy extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPharmacy = null;
    public $cart = [];
    public $showCart = false;
    public $deliveryType = 'pickup';
    public $deliveryAddress = '';
    public $patientNotes = '';
    public $userLatitude = null;
    public $userLongitude = null;
    public $showMap = false;
    public $isLocationEnabled = false; // New property

    protected $listeners = [
        'selectPharmacy',
        'setUserLocation',
    ];

    public function mount()
    {
        $this->cart = session()->get('pharmacy_cart', []);
        $this->getUserLocation();
        
        // Check if location was previously enabled
        if (session()->has('user_latitude') && session()->has('user_longitude')) {
            $this->isLocationEnabled = true;
        }
    }

    public function getUserLocation()
    {
        $this->userLatitude = session()->get('user_latitude');
        $this->userLongitude = session()->get('user_longitude');
    }

    public function requestLocation()
    {
        $this->dispatch('request-user-location');
    }

    public function setUserLocation($lat, $lng)
    {
        $this->userLatitude = $lat;
        $this->userLongitude = $lng;
        $this->isLocationEnabled = true;
        session()->put('user_latitude', $lat);
        session()->put('user_longitude', $lng);
        
        $this->dispatch('show-toast', type: 'success', message: 'Location enabled successfully!');
    }

    public function findNearbyPharmacies()
    {
        if (!$this->userLatitude || !$this->userLongitude) {
            $this->dispatch('show-toast', type: 'error', message: 'Please allow location access to find nearby pharmacies');
            return;
        }
        $this->showMap = true;
        $this->dispatch('refresh-map');
    }

    public function hideMap()
    {
        $this->showMap = false;
    }

    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));

        return $earthRadius * $c;
    }

    public function selectPharmacy($pharmacyId)
    {
        $this->selectedPharmacy = Pharmacy::with(['medicineStock' => function($query) {
            $query->where('quantity_available', '>', 0);
        }])->find($pharmacyId);
        
        $this->dispatch('scroll-to-pharmacy-details');
    }

    public function render()
    {
        $pharmaciesQuery = Pharmacy::where('status', 'approved')
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%');
            })
            ->with(['medicineStock' => function($query) {
                $query->where('quantity_available', '>', 0);
            }]);

        $allPharmacies = $pharmaciesQuery->get();

        // Calculate distances if user location is available
        if ($this->userLatitude && $this->userLongitude) {
            $allPharmacies = $allPharmacies->map(function($pharmacy) {
                $pharmacy->distance = $this->calculateDistance(
                    $this->userLatitude, 
                    $this->userLongitude,
                    $pharmacy->latitude ?? 0, 
                    $pharmacy->longitude ?? 0
                );
                return $pharmacy;
            })->sortBy('distance');
        }

        // Paginate the results
        $perPage = 12;
        $currentPage = \Illuminate\Pagination\LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $allPharmacies->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $pharmacies = new \Illuminate\Pagination\LengthAwarePaginator($currentItems, $allPharmacies->count(), $perPage);

        return view('livewire.patient.pharmacy', [
            'pharmacies' => $pharmacies,
            'cartTotal' => $this->getCartTotal(),
            'cartCount' => count($this->cart),
            'userLocation' => $this->userLatitude && $this->userLongitude,
        ]);
    }

    // Cart methods remain the same
    public function addToCart($medicineId)
    {
        $medicine = MedicineStock::find($medicineId);
        
        if (!$medicine || $medicine->quantity_available <= 0) {
            $this->dispatch('show-toast', type: 'error', message: 'Medicine out of stock');
            return;
        }

        if (isset($this->cart[$medicineId])) {
            if ($this->cart[$medicineId]['quantity'] >= $medicine->quantity_available) {
                $this->dispatch('show-toast', type: 'error', message: 'Maximum available quantity reached');
                return;
            }
            $this->cart[$medicineId]['quantity'] += 1;
        } else {
            $this->cart[$medicineId] = [
                'medicine_id' => $medicine->id,
                'name' => $medicine->medicine_name,
                'price' => $medicine->price,
                'quantity' => 1,
                'max_quantity' => $medicine->quantity_available,
                'pharmacy_id' => $medicine->pharmacy_id,
                'pharmacy_name' => $medicine->pharmacy->name ?? 'Unknown Pharmacy'
            ];
        }

        $this->saveCart();
        $this->dispatch('show-toast', type: 'success', message: 'Added to cart');
    }

    public function removeFromCart($medicineId)
    {
        unset($this->cart[$medicineId]);
        $this->saveCart();
        $this->dispatch('show-toast', type: 'success', message: 'Removed from cart');
    }

    public function updateCartQuantity($medicineId, $quantity)
    {
        if ($quantity <= 0) {
            $this->removeFromCart($medicineId);
            return;
        }

        $medicine = MedicineStock::find($medicineId);
        if ($medicine && $quantity <= $medicine->quantity_available) {
            $this->cart[$medicineId]['quantity'] = $quantity;
            $this->saveCart();
        } else {
            $this->dispatch('show-toast', type: 'error', message: 'Quantity exceeds available stock');
        }
    }

    public function getCartTotal()
    {
        return collect($this->cart)->sum(function($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function saveCart()
    {
        session()->put('pharmacy_cart', $this->cart);
    }

    public function clearCart()
    {
        $this->cart = [];
        session()->forget('pharmacy_cart');
        $this->dispatch('show-toast', type: 'success', message: 'Cart cleared');
    }

    public function toggleCart()
    {
        $this->showCart = !$this->showCart;
    }

    public function checkout()
    {
        if (empty($this->cart)) {
            $this->dispatch('show-toast', type: 'error', message: 'Cart is empty');
            return;
        }

        if ($this->deliveryType === 'delivery' && empty($this->deliveryAddress)) {
            $this->dispatch('show-toast', type: 'error', message: 'Delivery address is required');
            return;
        }

        // For now, use the first pharmacy in cart
        $firstItem = reset($this->cart);
        $pharmacyId = $firstItem['pharmacy_id'];

        try {
            $order = PharmacyOrder::create([
                'user_id' => auth()->id(),
                'pharmacy_id' => $pharmacyId,
                'order_number' => 'PO-' . time() . '-' . auth()->id(),
                'total_amount' => $this->getCartTotal(),
                'status' => 'pending',
                'delivery_type' => $this->deliveryType,
                'shipping_address' => $this->deliveryType === 'delivery' ? $this->deliveryAddress : null,
                'patient_notes' => $this->patientNotes,
                'payment_status' => 'pending',
                'notes' => $this->patientNotes,
            ]);

            // Create order items
            foreach ($this->cart as $item) {
                $order->items()->create([
                    'medicine_id' => $item['medicine_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                    'total_price' => $item['price'] * $item['quantity'],
                ]);

                // Update stock
                $medicine = MedicineStock::find($item['medicine_id']);
                if ($medicine) {
                    $medicine->decrement('quantity_available', $item['quantity']);
                }
            }

            $this->clearCart();
            $this->showCart = false;
            $this->dispatch('show-toast', type: 'success', message: 'Order placed successfully!');
            
        } catch (\Exception $e) {
            $this->dispatch('show-toast', type: 'error', message: 'Failed to place order: ' . $e->getMessage());
        }
    }
}