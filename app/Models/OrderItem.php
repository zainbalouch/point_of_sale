<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_id',
        'product_name_en',
        'product_name_ar',
        'product_description_en',
        'product_description_ar',
        'product_sku',
        'product_code',
        'product_id',
        'quantity',
        'tax_id',
        'note',
        'unit_price',
        'vat_amount',
        'other_taxes_amount',
        'discount_amount',
        'discount_type',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'discount_amount' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'other_taxes_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the unit price attribute.
     * Convert from stored integer value (cents) to decimal.
     */
    public function getUnitPriceAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the unit price attribute.
     * Convert from decimal to integer value (cents) for storage.
     */
    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value * 100;
    }

    public function getTotalPriceAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the unit price attribute.
     * Convert from decimal to integer value (cents) for storage.
     */
    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = $value * 100;
    }

    public function getVatAmountAttribute($value)
    {
        return $value / 100;
    }

    /**
     * Set the unit price attribute.
     * Convert from decimal to integer value (cents) for storage.
     */
    public function setVatAmountAttribute($value)
    {
        $this->attributes['vat_amount'] = $value * 100;
    }

    public function getOtherTaxesAmountAttribute($value)
    {
        return $value / 100;
    }
    public function setOtherTaxesAmountAttribute($value)
    {
        $this->attributes['other_taxes_amount'] = $value * 100;
    }

    public function getDiscountAmountAttribute($value)
    {
        return $value / 100;
    }
    public function setDiscountAmountAttribute($value)
    {
        $this->attributes['discount_amount'] = $value * 100;
    }


    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the tax associated with the order item.
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly($this->fillable)
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    public function getDiscountAttribute($value)
    {
        $discountType = $this->discount_type;
        $discountAmount = $this->discount_amount;

        if ($discountType === 'percentage') {
            return $this->unit_price * $this->quantity * $discountAmount / 100;
        } else {
            return $discountAmount;
        }
    }
}
