<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryItem extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'item_name',
        'item_code',
        'description',
        'category',
        'unit_of_measure',
        'quantity',
        'minimum_stock_level',
        'unit_price',
        'supplier_name',
        'batch_number',
        'manufacturing_date',
        'expiry_date',
        'storage_location',
        'qr_code',
        'is_critical',
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiry_date' => 'date',
        'is_critical' => 'boolean',
        'unit_price' => 'decimal:2',
    ];

    // Relationships
    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }

    // Accessors & Mutators
    public function getIsLowStockAttribute()
    {
        return $this->quantity <= $this->minimum_stock_level;
    }

    public function getIsExpiringAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }
        $daysUntilExpiry = now()->diffInDays($this->expiry_date, false);
        return $daysUntilExpiry <= 30 && $daysUntilExpiry > 0;
    }

    public function getIsExpiredAttribute()
    {
        if (!$this->expiry_date) {
            return false;
        }
        return $this->expiry_date < now();
    }

    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->unit_price;
    }

    // Scopes
    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock_level');
    }

    public function scopeExpiring($query, $days = 30)
    {
        return $query->whereNotNull('expiry_date')
                     ->whereDate('expiry_date', '>', now())
                     ->whereDate('expiry_date', '<=', now()->addDays($days));
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
                     ->whereDate('expiry_date', '<', now());
    }

    public function scopeCritical($query)
    {
        return $query->where('is_critical', true);
    }
}
