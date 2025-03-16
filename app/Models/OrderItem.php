<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'order_id',
        'product_name_en',
        'product_name_ar',
        'product_description_en',
        'product_description_ar',
        'product_sku',
        'product_code',
        'product_id',
        'quantity',
        'unit_price',
        'tax_id',
        'tax_amount',
        'discount_amount',
        'total_price',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'integer',
        'tax_amount' => 'integer',
        'discount_amount' => 'integer',
        'total_price' => 'integer',
    ];

    /**
     * Get the order that owns the item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product associated with the order item.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the tax associated with the order item.
     */
    public function tax()
    {
        return $this->belongsTo(Tax::class);
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
