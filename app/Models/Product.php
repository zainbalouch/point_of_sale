<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
