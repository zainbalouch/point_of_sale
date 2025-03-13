<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'number',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'customer_id',
        'order_status_id',
        'shipping_fee',
        'subtotal',
        'tax',
        'total',
        'payment_method_id',
        'currency_id',
        'estimated_delivery_at',
        'delivered_at',
        'shipped_at',
    ];

    protected $casts = [
        'estimated_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shipped_at' => 'datetime',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function shippingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')->where('address_type_id', AddressType::SHIPPING);
    }

    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')->where('address_type_id', AddressType::BILLING);
    }

    protected static function boot()
    {
        parent::boot();

        // This event will be fired just before a new order is created
        static::creating(function ($order) {
            // Generate a unique number for the order
            $order->number = static::generateUniqueNumber();
        });
    }

    private static function generateUniqueNumber()
    {
        return setting('order_number_prefix') . '-' . time() . rand(1000, 9999);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
