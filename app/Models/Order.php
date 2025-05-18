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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

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

        static::addGlobalScope('company', function (Builder $builder) {
            $user = Auth::user();
            if ($user) {
                if ($user->point_of_sale_id) {
                    $builder->where('point_of_sale_id', $user->point_of_sale_id);
                } elseif ($user->company_id) {
                    $builder->whereHas('company', function ($query) {
                        $query->where('is_active', true);
                    })->where('company_id', $user->company_id);
                }
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user) {
                if ($user->point_of_sale_id) {
                    if ($model->point_of_sale_id !== $user->point_of_sale_id) {
                        abort(403, 'Cannot update record for different point of sale');
                    }
                } elseif ($user->company_id) {
                    if (!$model->company || !$model->company->is_active) {
                        abort(403, 'Cannot update record for inactive company');
                    }
                }
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user) {
                if ($user->point_of_sale_id) {
                    if ($model->point_of_sale_id !== $user->point_of_sale_id) {
                        abort(403, 'Cannot delete record for different point of sale');
                    }
                } elseif ($user->company_id) {
                    if (!$model->company || !$model->company->is_active) {
                        abort(403, 'Cannot delete record for inactive company');
                    }
                }
            }
        });
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
