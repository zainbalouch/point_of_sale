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
        'product_name_en',
        'product_name_ar',
        'product_description_en',
        'product_description_ar',
        'product_sku',
        'product_code',
        'quantity',
        'unit_price',
        'vat_amount',
        'other_taxes_amount',
        'discount_amount',
        'total_price',
        'note'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'other_taxes_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_price' => 'decimal:2',
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

    public function getVatAmountAttribute($value)
    {
        return $value / 100;
    }

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

    public function getTotalPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalPriceAttribute($value)
    {
        $this->attributes['total_price'] = $value * 100;
    }

    // Relationships
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
