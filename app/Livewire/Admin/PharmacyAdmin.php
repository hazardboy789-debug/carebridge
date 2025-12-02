<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pharmacy;
use App\Models\MedicineStock;
use App\Models\PharmacyOrder;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]

class PharmacyAdmin extends Component
{
    use WithPagination;

    public $search = '';
    public $pharmacies;
    public $selectedPharmacy = null;
    public $medicineName = '';
    public $medicinePrice = '';
    public $medicineQuantity = '';
    public $medicineDescription = '';
    public $showOrders = false;
    public $orders = [];

    public function render()
    {
        $query = Pharmacy::query()
            ->when($this->search, function($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('address', 'like', '%' . $this->search . '%')
                      ->orWhere('phone', 'like', '%' . $this->search . '%');
            });

        $this->pharmacies = $query->paginate(10);

        return view('livewire.admin.pharmacy', [
            'pharmacies' => $this->pharmacies,
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
        session()->flash('message', 'Medicine added successfully!');
    }

    public function updateMedicineStock($medicineId, $quantity)
    {
        $medicine = MedicineStock::find($medicineId);
        if ($medicine) {
            $medicine->update(['quantity_available' => $quantity]);
            session()->flash('message', 'Stock updated successfully!');
        }
    }

    public function deleteMedicine($medicineId)
    {
        MedicineStock::find($medicineId)->delete();
        $this->selectPharmacy($this->selectedPharmacy->id); // Refresh
        session()->flash('message', 'Medicine deleted successfully!');
    }

    public function togglePharmacyStatus($pharmacyId)
    {
        $pharmacy = Pharmacy::find($pharmacyId);
        if ($pharmacy) {
            $pharmacy->update(['status' => $pharmacy->status === 'approved' ? 'pending' : 'approved']);
            session()->flash('message', 'Pharmacy status updated!');
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
            session()->flash('message', 'Order status updated!');
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

        Pharmacy::create([
            'name' => $this->newPharmacyName,
            'address' => $this->newPharmacyAddress,
            'phone' => $this->newPharmacyPhone,
            'latitude' => $this->newPharmacyLatitude,
            'longitude' => $this->newPharmacyLongitude,
            'status' => 'approved',
            'is_open' => true,
            'opening_time' => '08:00:00',
            'closing_time' => '22:00:00',
            'is_24_hours' => false,
        ]);

        $this->reset(['newPharmacyName', 'newPharmacyAddress', 'newPharmacyPhone', 
                     'newPharmacyLatitude', 'newPharmacyLongitude']);
        session()->flash('message', 'Pharmacy added successfully!');
    }

    public function deletePharmacy($pharmacyId)
    {
        // Delete associated medicines first
        MedicineStock::where('pharmacy_id', $pharmacyId)->delete();
        
        // Then delete the pharmacy
        Pharmacy::find($pharmacyId)->delete();
        
        session()->flash('message', 'Pharmacy deleted successfully!');
        $this->selectedPharmacy = null;
    }

    private function resetMedicineForm()
    {
        $this->medicineName = '';
        $this->medicinePrice = '';
        $this->medicineQuantity = '';
        $this->medicineDescription = '';
    }
}