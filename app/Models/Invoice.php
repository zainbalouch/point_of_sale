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
        'vat',
        'other_taxes',
        'discount',
        'total',
        'amount_paid',
        'issue_date',
        'due_date',
        'paid_date',
        'invoice_status_id',
        'currency_id',
        'issued_by_user',
        'point_of_sale_id',
        'meta',
        'order_id',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
        'meta' => 'json',
        'subtotal' => 'decimal:2',
        'vat' => 'decimal:2',
        'other_taxes' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
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

    public function getVatAttribute($value)
    {
        return $value / 100;
    }

    public function setVatAttribute($value)
    {
        $this->attributes['vat'] = $value * 100;
    }

    public function getOtherTaxesAttribute($value)
    {
        return $value / 100;
    }

    public function setOtherTaxesAttribute($value)
    {
        $this->attributes['other_taxes'] = $value * 100;
    }

    public function getDiscountAttribute($value)
    {
        return $value / 100;
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = $value * 100;
    }

    public function getTotalAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $value * 100;
    }

    public function getAmountPaidAttribute($value)
    {
        return $value / 100;
    }

    public function setAmountPaidAttribute($value)
    {
        $this->attributes['amount_paid'] = $value * 100;
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
        return $this->belongsTo(Customer::class, 'customer_id');
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
     * Get the point of sale associated with the invoice.
     */
    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
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

    /**
     * Get the order associated with the invoice.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    // Generate consecutive invoice number when creating a new invoice
    public static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            // Get the last invoice number for this company, including soft-deleted records
            $lastInvoice = static::withTrashed()
                ->where('company_id', $invoice->company_id)
                ->orderBy('number', 'desc')
                ->first();

            // Extract the sequence number from the last invoice
            $lastNumber = 0;
            if ($lastInvoice) {
                // Split the number by '-' and get the last part
                $parts = explode('-', $lastInvoice->number);
                $lastNumber = intval(end($parts));
            }

            // Generate the next consecutive number
            $nextNumber = $lastNumber + 1;

            // Create the new invoice number with company prefix and padded number
            $invoice->number = sprintf('C%03d-INV-%06d', $invoice->company_id, $nextNumber);
        });
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
