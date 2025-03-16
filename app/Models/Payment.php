<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Payment extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'invoice_id',
        'payment_status_id',
        'payment_method_id',
        'currency_id',
        'amount',
        'payment_date',
        'transaction_reference',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'payment_date' => 'datetime',
        'meta' => 'json',
        'amount' => 'integer',
    ];

    /**
     * Get the order that the payment belongs to.
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the invoice that the payment belongs to.
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the payment status that the payment belongs to.
     */
    public function status(): BelongsTo
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    /**
     * Get the payment method that the payment belongs to.
     */
    public function method(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * Get the currency that the payment belongs to.
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Format the amount with currency.
     */
    public function formattedAmount(): string
    {
        if (!$this->currency) {
            return number_format($this->amount / 100, 2);
        }

        return $this->currency->symbol . ' ' . number_format($this->amount / 100, 2);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}