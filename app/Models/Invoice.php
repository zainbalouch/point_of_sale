<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Invoice extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'company_id',
        'customer_id',
        'billing_address_id',
        'shipping_address_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'issue_date',
        'due_date',
        'paid_date',
        'invoice_status_id',
        'currency_id',
        'issued_by_user',
        'meta',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
        'meta' => 'json',
    ];

    // Money fields accessors and mutators
    public function getSubtotalAttribute($value)
    {
        return $value / 100;
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $value * 100;
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

    public function getTotalAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalAmountAttribute($value)
    {
        $this->attributes['total_amount'] = $value * 100;
    }

    // Relationships
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function issuedByUser()
    {
        return $this->belongsTo(User::class, 'issued_by_user');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    // Helper to check if invoice is paid
    public function isPaid(): bool
    {
        return !is_null($this->paid_date);
    }

    // Helper to check if invoice is overdue
    public function isOverdue(): bool
    {
        return !$this->isPaid() && $this->due_date && $this->due_date->isPast();
    }
}
