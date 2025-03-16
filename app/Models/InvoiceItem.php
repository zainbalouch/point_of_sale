<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class InvoiceItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'invoiceable_id',
        'invoiceable_type',
        'product_name_en',
        'product_name_ar',
        'product_description_en',
        'product_description_ar',
        'product_sku',
        'product_code',
        'quantity',
        'unit_price',
        'tax_id',
        'tax_amount',
        'discount_amount',
        'subtotal',
        'total'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Money fields accessors and mutators
    public function getUnitPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value * 100;
    }

    public function getTaxAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setTaxAmountAttribute($value)
    {
        $this->attributes['tax_amount'] = $value * 100;
    }

    public function getDiscountAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setDiscountAmountAttribute($value)
    {
        $this->attributes['discount_amount'] = $value * 100;
    }

    public function getSubtotalAttribute($value)
    {
        return $value / 100;
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $value * 100;
    }

    public function getTotalAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $value * 100;
    }

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }

    public function invoiceable()
    {
        return $this->morphTo();
    }

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
