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
        'quantity',
        'sale_price',
        'currency_id',
        'product_category_id',
        'point_of_sale_id',
        'is_active',
        'image_url',
        'company_id',
    ];

    // TODO: Add accessor and mutator for formattedPrice
    protected $appends = ['image_url_path', 'name', 'description', 'formattedPrice'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class)
            ->withTimestamps()
            ->withPivot('deleted_at');
    }

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"name_$locale"};
    }

    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        return $this->{"description_$locale"};
    }

    // TODO: Add accessor and mutator for formattedPrice
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2, '.', ',');
    }

    /**
     * Calculate VAT amount for the product
     *
     * @return float
     */
    public function getVatAmount()
    {
        $vatTax = $this->taxes()->where('name_en', 'VAT')->first();

        if (!$vatTax) {
            return 0;
        }

        if ($vatTax->type === 'percentage') {
            return floatval($this->price) * (floatval($vatTax->amount) / 100);
        }

        return floatval($vatTax->amount);
    }

    /**
     * Calculate sum of all taxes except VAT
     *
     * @return float
     */
    public function getOtherTaxesAmount()
    {
        $otherTaxes = $this->taxes()->where('name_en', '!=', 'VAT')->get();
        $taxesTotal = 0;

        foreach ($otherTaxes as $tax) {
            if ($tax->type === 'percentage') {
                $taxesTotal += floatval($this->price) * (floatval($tax->amount) / 100);
            } else {
                $taxesTotal += floatval($tax->amount);
            }
        }

        return $taxesTotal;
    }
}
