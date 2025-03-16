<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Order extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'number',
        'customer_id',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'company_id',
        'order_status_id',
        'shipping_fee',
        'subtotal',
        'tax',
        'total',
        'payment_method_id',
        'currency_id',
        'billing_address_id',
        'shipping_address_id',
        'estimated_delivery_at',
        'delivered_at',
        'shipped_at',
        'meta',
    ];

    protected $casts = [
        'estimated_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'meta' => 'array',
        'shipping_fee' => 'integer',
        'subtotal' => 'integer',
        'tax' => 'integer',
        'total' => 'integer',
    ];

    /**
     * Get the customer associated with the order.
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the company associated with the order.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the status of the order.
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the payment method for the order.
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the currency used for the order.
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the billing address for the order.
     */
    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    /**
     * Get the shipping address for the order.
     */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the notes for the order.
     */
    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
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
