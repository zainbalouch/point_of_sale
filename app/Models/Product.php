<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Invoiceable;
use App\Traits\Notable;

class Product extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Invoiceable, Notable;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'sku',
        'code',
        'price',
        'sale_price',
        'currency_id',
        'product_category_id',
        'company_id',
        'image_url',
    ];

    protected $appends = ['image_url_path'];

    /**
     * Get the company this product belongs to
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getImageUrlPathAttribute()
    {
        if (!$this->image_url) {
            return null;
        }
        
        return asset('storage/' . $this->image_url);
    }

    // Add accessor and mutator because price is stored as integer
    public function getPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setPriceAttribute($value)
    {
        $this->attributes['price'] = $value * 100;
    }
    
    public function getSalePriceAttribute($value)
    {
        return $value / 100;
    }

    public function setSalePriceAttribute($value)
    {
        $this->attributes['sale_price'] = $value * 100;
    }
    
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('Y-m-d');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Get invoice items related to this product
     */
    public function invoiceItems()
    {
        return $this->morphMany(InvoiceItem::class, 'invoiceable_item');
    }

    /**
     * Scope a query to only include products for a given company
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    protected static function boot()
    {
        parent::boot();

        // Set the company ID from the authenticated user if not provided
        static::creating(function ($product) {
            if (empty($product->company_id) && auth()->check()) {
                $product->company_id = auth()->user()->company_id;
            }
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
