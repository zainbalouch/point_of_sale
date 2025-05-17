<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'number',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'user_id',
        'company_id',
        'order_status_id',
        'issue_date',
        'shipping_fee',
        'subtotal',
        'subtotal_after_discount',
        'vat',
        'other_taxes',
        'discount',
        'discount_type',
        'discount_totals',
        'total',
        'amount_paid',
        'payment_method_id',
        'currency_id',
        'billing_address_id',
        'shipping_address_id',
        'estimated_delivery_at',
        'delivered_at',
        'shipped_at',
        'meta',
        'point_of_sale_id',
    ];

    protected $casts = [
        'estimated_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'meta' => 'array',
        'shipping_fee' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'vat' => 'decimal:2',
        'other_taxes' => 'decimal:2',
        'discount' => 'decimal:2',
        'discount_totals' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Bootstrap the model and its traits.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            // Only generate number if it's not already set
            if (empty($order->number)) {
                // Get the current year and month
                $datePrefix = now()->format('Ym');

                // Get the last order number for this month
                $lastOrder = static::where('number', 'like', "ORD-{$datePrefix}-%")
                    ->orderBy('number', 'desc')
                    ->first();

                // Extract the sequence number from the last order or start from 1
                $sequence = 1;
                if ($lastOrder) {
                    $lastSequence = (int) substr($lastOrder->number, -6);
                    $sequence = $lastSequence + 1;
                }

                // Generate the new order number with padded sequence
                $order->number = "ORD-{$datePrefix}-" . str_pad($sequence, 6, '0', STR_PAD_LEFT);
            }
        });

        // static::created(function ($order) {
        //     // Create an invoice for the order
        //     $invoice = new Invoice([
        //         'customer_name' => $order->customer->full_name,
        //         'customer_email' => $order->customer->email,
        //         'customer_phone' => $order->customer->phone_number,
        //         'company_id' => $order->company_id,
        //         'customer_id' => $order->customer_id,
        //         'billing_address_id' => $order->billing_address_id,
        //         'shipping_address_id' => $order->shipping_address_id,
        //         'subtotal' => $order->subtotal,
        //         'vat' => $order->vat,
        //         'other_taxes' => $order->other_taxes,
        //         'discount_amount' => $order->discount,
        //         'total_amount' => $order->total,
        //         'amount_paid' => $order->amount_paid,
        //         'issue_date' => now(),
        //         'due_date' => now()->addDays(30), // 30 days due date
        //         'invoice_status_id' => 1, // Draft status
        //         'currency_id' => $order->currency_id,
        //         'issued_by_user' => $order->user_id,
        //         'point_of_sale_id' => $order->point_of_sale_id,
        //         'meta' => [
        //             'order_id' => $order->id,
        //             'order_number' => $order->number
        //         ]
        //     ]);

        //     $invoice->save();

        //     // Create invoice items from order items
        //     foreach ($order->items as $item) {
        //         $invoiceItem = new InvoiceItem([
        //             'invoice_id' => $invoice->id,
        //             'product_name_en' => $item->product_name_en,
        //             'product_name_ar' => $item->product_name_ar,
        //             'product_description_en' => $item->product_description_en,
        //             'product_description_ar' => $item->product_description_ar,
        //             'product_sku' => $item->product_sku,
        //             'product_code' => $item->product_code,
        //             'quantity' => $item->quantity,
        //             'unit_price' => $item->unit_price,
        //             'vat_amount' => $item->vat_amount,
        //             'other_taxes_amount' => $item->other_taxes_amount,
        //             'discount_amount' => $item->discount_amount,
        //             'subtotal' => $item->total_price,
        //             'total' => $item->total_price,
        //             'note' => $item->note
        //         ]);

        //         $invoiceItem->save();
        //     }
        // });
    }

    /**
     * Get the user associated with the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer associated with the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the company associated with the order.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the status of the order.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the payment method for the order.
     */
    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the currency used for the order.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the billing address for the order.
     */
    public function billingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the shipping address for the order.
     */
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * Get the items for the order.
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the notes for the order.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Get the point of sale associated with the order.
     */
    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }

    /**
     * Get the invoices for the order.
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }



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

    public function getDiscountTotalsAttribute($value)
    {
        return $value / 100;
    }

    public function setDiscountTotalsAttribute($value)
    {
        $this->attributes['discount_totals'] = $value * 100;
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
}
