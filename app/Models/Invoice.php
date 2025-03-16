<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    /**
     * Get the items for the invoice.
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the status of the invoice.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    /**
     * Get the company associated with the invoice.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the customer associated with the invoice.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the billing address for the invoice.
     */
    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the shipping address for the invoice.
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * Get the currency used for the invoice.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the user who issued the invoice.
     */
    public function issuedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by_user');
    }

    /**
     * Get the payments for the invoice.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the notes associated with the invoice.
     */
    public function notes(): MorphMany
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
