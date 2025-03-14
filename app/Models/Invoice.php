<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Notable;
use App\Traits\Addressable;

class Invoice extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Notable, Addressable;

    protected $fillable = [
        'invoice_number',
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
        'issue_datetime',
        'due_datetime',
        'paid_datetime',
        'invoice_status_id',
        'currency_id',
    ];

    protected $casts = [
        'issue_datetime' => 'datetime',
        'due_datetime' => 'datetime',
        'paid_datetime' => 'datetime',
    ];

    /**
     * Get the company this invoice belongs to
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    /**
     * Get the customer this invoice belongs to
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the invoiceable entity
     */
    public function invoiceable()
    {
        return $this->morphTo();
    }

    /**
     * Get the invoice items for this invoice
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the billing address for this invoice
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the shipping address for this invoice
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * Get the status of this invoice
     */
    public function status()
    {
        return $this->belongsTo(InvoiceStatus::class, 'invoice_status_id');
    }

    /**
     * Get the currency of this invoice
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Scope to filter invoices by company
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Add an item to this invoice from a product
     *
     * @param Product $product
     * @param int $quantity
     * @param float|null $unitPrice
     * @param int|null $taxRateId
     * @return InvoiceItem
     */
    public function addProduct(Product $product, int $quantity = 1, float $unitPrice = null, int $taxRateId = null)
    {
        $itemData = [
            'invoice_id' => $this->id,
            'quantity' => $quantity,
            'company_id' => $this->company_id, // Pass company_id for tax rate lookup
        ];
        
        if ($unitPrice !== null) {
            $itemData['unit_price'] = $unitPrice;
        }
        
        if ($taxRateId !== null) {
            $itemData['tax_rate_id'] = $taxRateId;
        }
        
        $invoiceItem = InvoiceItem::createFromProduct($product, $itemData);
        $this->items()->save($invoiceItem);
        $invoiceItem->calculateAmounts();
        
        return $invoiceItem;
    }

    /**
     * Money accessors and mutators
     */
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

    /**
     * Add helper methods for datetime formatting
     */
    public function getFormattedIssueDatetimeAttribute()
    {
        return $this->issue_datetime ? $this->issue_datetime->format('Y-m-d H:i:s') : null;
    }

    public function getFormattedDueDatetimeAttribute()
    {
        return $this->due_datetime ? $this->due_datetime->format('Y-m-d H:i:s') : null;
    }

    public function getFormattedPaidDatetimeAttribute()
    {
        return $this->paid_datetime ? $this->paid_datetime->format('Y-m-d H:i:s') : null;
    }

    /**
     * Check if invoice is overdue
     */
    public function isOverdue()
    {
        return !$this->paid_datetime && $this->due_datetime && $this->due_datetime->isPast();
    }

    /**
     * Calculate totals based on invoice items
     */
    public function calculateTotals()
    {
        $items = $this->items;
        
        $subtotal = $items->sum('subtotal');
        $taxAmount = $items->sum('tax_amount');
        $discountAmount = $items->sum('discount_amount');
        $totalAmount = $subtotal + $taxAmount - $discountAmount;

        $this->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        // This event will be fired just before a new invoice is created
        static::creating(function ($invoice) {
            // Generate a unique invoice number
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = static::generateInvoiceNumber();
            }
            
            // If no company is set, try to get it from the authenticated user
            if (empty($invoice->company_id) && auth()->check()) {
                $invoice->company_id = auth()->user()->company_id;
            }
        });
    }

    /**
     * Activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    /**
     * Generate a unique invoice number
     */
    public static function generateInvoiceNumber()
    {
        $prefix = 'INV-';
        $year = date('Y');
        $month = date('m');
        
        $latestInvoice = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->latest()
            ->first();
            
        $sequence = $latestInvoice ? intval(substr($latestInvoice->invoice_number, -4)) + 1 : 1;
        
        return $prefix . $year . $month . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}
