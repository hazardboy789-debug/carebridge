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
    use \Livewire\WithFileUploads;
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

    // Prescription upload
    public $prescription;
    public $prescriptionPath;
    public function uploadPrescription()
    {
        if (!$this->selectedPharmacy) {
            $this->addError('prescription', 'Please select a pharmacy before uploading.');
            return;
        }
        $this->validate([
            'prescription' => 'required|file|mimes:pdf|max:5120', // 5MB max, PDF only
        ], [
            'prescription.required' => 'Please select a prescription file to upload.',
            'prescription.mimes' => 'Only PDF files are allowed.',
            'prescription.max' => 'File size must not exceed 5MB.',
        ]);

        $path = $this->prescription->store('prescriptions', 'public');
        $this->prescriptionPath = $path;

        // Extract medicines from PDF using spatie/pdf-to-text
        $pdfPath = storage_path('app/public/' . $path);
        $medicines = [];
        try {
            $pdfText = \Spatie\PdfToText\Pdf::getText($pdfPath);
            // Find the "Prescribed Medications" section
            if (preg_match('/Prescribed Medications(.+?)(Instructions|Instructions & Notes|Signature|$)/is', $pdfText, $medBlock)) {
                $table = $medBlock[1];
                // Match table rows (skip header)
                $lines = preg_split('/\r?\n/', trim($table));
                foreach ($lines as $line) {
                    // Skip header or empty lines
                    if (stripos($line, 'Medication') !== false || trim($line) === '') continue;
                    // Split columns by whitespace (may need adjustment for your PDF)
                    $cols = preg_split('/\s{2,}/', trim($line));
                    if (count($cols) >= 1) {
                        $name = $cols[0];
                        $dosage = $cols[1] ?? '';
                        $frequency = $cols[2] ?? '';
                        $duration = $cols[3] ?? '';
                        $medicines[] = trim($name . '|' . $dosage . '|' . $frequency . '|' . $duration, '|');
                    }
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('show-toast', type: 'error', message: 'Could not extract medicines from PDF: ' . $e->getMessage());
        }

        // Find or create a pending order for this patient and selected pharmacy
        $order = \App\Models\PharmacyOrder::where('user_id', auth()->id())
            ->where('pharmacy_id', $this->selectedPharmacy->id)
            ->where('status', 'pending')
            ->latest('created_at')
            ->first();

        if (!$order) {
            $order = new \App\Models\PharmacyOrder();
            $order->user_id = auth()->id();
            $order->pharmacy_id = $this->selectedPharmacy->id;
            $order->status = 'pending';
            $order->order_number = 'RX-' . strtoupper(uniqid());
            $order->total_amount = 0;
            $order->delivery_type = 'pickup';
            $order->payment_status = 'pending';
            $order->shipping_address = '';
            $order->save();
        }

        // Save prescription with order_id and pharmacy_id
        $prescription = new \App\Models\Prescription();
        $prescription->patient_id = auth()->id();
        $prescription->pharmacy_id = $this->selectedPharmacy->id;
        $prescription->order_id = $order->id;
        $prescription->file_path = $path;
        $prescription->diagnosis = '';
        $prescription->symptoms = '';
        $prescription->medicines = $medicines;
        $prescription->instructions = '';
        $prescription->notes = '';
        $prescription->follow_up_date = null;
        $prescription->save();

        // Auto-fill order items from prescription medicines (improved matching)
        $medicines = is_array($prescription->medicines) ? $prescription->medicines : (json_decode($prescription->medicines, true) ?? []);
        foreach ($medicines as $med) {
            $parts = explode('|', $med);
            $name = trim($parts[0] ?? '');
            if (!$name) continue;
            // Case-insensitive, partial match in this pharmacy's stock
            $medicineStock = \App\Models\MedicineStock::where('pharmacy_id', $this->selectedPharmacy->id)
                ->whereRaw('LOWER(medicine_name) LIKE ?', ['%' . strtolower($name) . '%'])
                ->first();
            if ($medicineStock) {
                // Add to order items if not already present
                $existingItem = \App\Models\OrderItem::where('order_id', $order->id)
                    ->where('medicine_id', $medicineStock->id)
                    ->first();
                if (!$existingItem) {
                    $orderItem = new \App\Models\OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->medicine_id = $medicineStock->id;
                    $orderItem->medicine_name = $medicineStock->medicine_name;
                    $orderItem->quantity = 1;
                    $orderItem->unit_price = $medicineStock->price;
                    $orderItem->total_price = $medicineStock->price;
                    $orderItem->notes = '';
                    $orderItem->save();
                }
                // Add to patient cart/session for UI
                if (!isset($this->cart[$medicineStock->id])) {
                    $this->cart[$medicineStock->id] = [
                        'medicine_id' => $medicineStock->id,
                        'name' => $medicineStock->medicine_name,
                        'price' => $medicineStock->price,
                        'quantity' => 1,
                        'max_quantity' => $medicineStock->quantity_available,
                        'pharmacy_id' => $medicineStock->pharmacy_id,
                        'pharmacy_name' => $medicineStock->pharmacy->name ?? 'Unknown Pharmacy',
                    ];
                    $this->dispatch('show-toast', type: 'info', message: 'Added to cart: ' . $medicineStock->medicine_name);
                }
            } else {
                $this->dispatch('show-toast', type: 'warning', message: 'Not found in stock: ' . $name);
            }
        }
        $this->saveCart();
        $this->dispatch('refresh-cart-ui');

        $this->dispatch('show-toast', type: 'success', message: 'Prescription uploaded and medicines added to order!');
    }

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
            'prescriptionPath' => $this->prescriptionPath,
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