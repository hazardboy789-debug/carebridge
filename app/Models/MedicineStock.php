<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineStock extends Model
{
    use HasFactory;

    protected $table = 'medicine_stock';

    protected $fillable = [
        'pharmacy_id',
        'medicine_name',
        'description',
        'manufacturer',
        'price',
        'quantity_available',
        'min_stock_level',
        'category',
        'prescription_required',
        'side_effects',
        'usage_instructions',
        'image',
        'is_active'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Relationship with Pharmacy
     */
    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    /**
     * Check if medicine is in stock
     */
    public function getIsInStockAttribute()
    {
        return $this->quantity_available > 0;
    }

    /**
     * Check if stock is low
     */
    public function getIsLowStockAttribute()
    {
        return $this->quantity_available <= $this->min_stock_level;
    }

    /**
     * Scope for active medicines
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for medicines that don't require prescription
     */
    public function scopeWithoutPrescription($query)
    {
        return $query->where('prescription_required', 'no');
    }

    /**
     * Scope for medicines by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope for searching medicines
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('medicine_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
    }
}