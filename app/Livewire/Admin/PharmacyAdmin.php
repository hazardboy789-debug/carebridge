<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Schema;
use App\Models\MedicineStock;
use App\Models\PharmacyOrder;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class PharmacyAdmin extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedPharmacy = null;
    public $medicineName = '';
    public $medicinePrice = '';
    public $medicineQuantity = '';
    public $medicineDescription = '';
    public $showOrders = false;
    public $orders = [];
    
    // Add these properties for pharmacy form
    public $showAddPharmacyForm = false;
    public $newPharmacyName = '';
    public $newPharmacyAddress = '';
    public $newPharmacyPhone = '';
    public $newPharmacyLatitude = '';
    public $newPharmacyLongitude = '';

    public function render()
    {
        $query = Pharmacy::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            });

        $pharmacies = $query->paginate(10);

        return view('livewire.admin.pharmacy', [
            'pharmacies' => $pharmacies,
        ]);
    }

    public function selectPharmacy($pharmacyId)
    {
        $this->selectedPharmacy = Pharmacy::with('medicineStock')->find($pharmacyId);
        $this->resetMedicineForm();
    }

    public function addMedicine()
    {
        $this->validate([
            'medicineName' => 'required|string|max:255',
            'medicinePrice' => 'required|numeric|min:0',
            'medicineQuantity' => 'required|integer|min:1',
        ]);

        MedicineStock::create([
            'pharmacy_id' => $this->selectedPharmacy->id,
            'medicine_name' => $this->medicineName,
            'price' => $this->medicinePrice,
            'quantity_available' => $this->medicineQuantity,
            'description' => $this->medicineDescription,
        ]);

        $this->resetMedicineForm();
        $this->selectPharmacy($this->selectedPharmacy->id); // Refresh
        $this->dispatch('show-toast', type: 'success', message: 'Medicine added successfully!');
    }

    public function updateMedicineStock($medicineId, $quantity)
    {
        $medicine = MedicineStock::find($medicineId);
        if ($medicine) {
            $medicine->update(['quantity_available' => $quantity]);
            $this->dispatch('show-toast', type: 'success', message: 'Stock updated successfully!');
        }
    }

    public function deleteMedicine($medicineId)
    {
        MedicineStock::find($medicineId)->delete();
        $this->selectPharmacy($this->selectedPharmacy->id); // Refresh
        $this->dispatch('show-toast', type: 'success', message: 'Medicine deleted successfully!');
    }

    public function togglePharmacyStatus($pharmacyId)
    {
        $pharmacy = Pharmacy::find($pharmacyId);
        if ($pharmacy) {
            $pharmacy->update(['status' => $pharmacy->status === 'approved' ? 'pending' : 'approved']);
            $this->dispatch('show-toast', type: 'success', message: 'Pharmacy status updated!');
        }
    }

    public function viewOrders($pharmacyId)
    {
        $this->showOrders = true;
        // FIX: Use 'user' relationship if it exists, otherwise join or eager load
        $this->orders = PharmacyOrder::with(['user', 'pharmacy', 'items'])
            ->where('pharmacy_id', $pharmacyId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = PharmacyOrder::find($orderId);
        if ($order) {
            $order->update(['status' => $status]);
            $this->dispatch('show-toast', type: 'success', message: 'Order status updated!');
        }
    }

    public function addNewPharmacy()
    {
        $this->validate([
            'newPharmacyName' => 'required|string|max:255',
            'newPharmacyAddress' => 'required|string',
            'newPharmacyPhone' => 'required|string',
            'newPharmacyLatitude' => 'required|numeric',
            'newPharmacyLongitude' => 'required|numeric',
        ]);

        $data = [
            'name' => $this->newPharmacyName,
            'address' => $this->newPharmacyAddress,
            'phone' => $this->newPharmacyPhone,
            'status' => 'approved',
            'is_open' => true,
        ];

        // Only include latitude/longitude if the DB column exists
        if (Schema::hasColumn('pharmacies', 'latitude')) {
            $data['latitude'] = $this->newPharmacyLatitude;
        }
        if (Schema::hasColumn('pharmacies', 'longitude')) {
            $data['longitude'] = $this->newPharmacyLongitude;
        }

        // Add opening/closing times only if columns exist
        if (Schema::hasColumn('pharmacies', 'opening_time')) {
            $data['opening_time'] = '08:00:00';
        }
        if (Schema::hasColumn('pharmacies', 'closing_time')) {
            $data['closing_time'] = '22:00:00';
        }
        if (Schema::hasColumn('pharmacies', 'is_24_hours')) {
            $data['is_24_hours'] = false;
        }

        Pharmacy::create($data);

        $this->resetNewPharmacyForm();
        $this->dispatch('show-toast', type: 'success', message: 'Pharmacy added successfully!');
    }

    public function deletePharmacy($pharmacyId)
    {
        // Delete associated medicines first
        MedicineStock::where('pharmacy_id', $pharmacyId)->delete();
        
        // Then delete the pharmacy
        Pharmacy::find($pharmacyId)->delete();
        
        $this->dispatch('show-toast', type: 'success', message: 'Pharmacy deleted successfully!');
        $this->selectedPharmacy = null;
    }

    private function resetMedicineForm()
    {
        $this->medicineName = '';
        $this->medicinePrice = '';
        $this->medicineQuantity = '';
        $this->medicineDescription = '';
    }

    private function resetNewPharmacyForm()
    {
        $this->newPharmacyName = '';
        $this->newPharmacyAddress = '';
        $this->newPharmacyPhone = '';
        $this->newPharmacyLatitude = '';
        $this->newPharmacyLongitude = '';
        $this->showAddPharmacyForm = false;
    }
}