<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ProductCategory extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'parent_id',
        'company_id',
        'point_of_sale_id',

    ];

    protected $appends = ['name', 'description'];

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

    public function parentCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function childCategories()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function buildBreadcrumbs($categoryId, $prefix = '', $startCategoryId = null)
    {
        $breadcrumbs = [];

        $category = $this->find($categoryId);

        if ($category && $category->id !== $startCategoryId) {
            // Add the current category regardless of children
            $breadcrumbs[] = [
                'id' => $category->id,
                'name' => $prefix . $category->{'name_' . app()->getLocale()},
            ];

            if ($category->parent_id) {
                $breadcrumbs = array_merge(
                    $breadcrumbs,
                    $this->buildBreadcrumbs($category->parent_id, $prefix, $startCategoryId ?: $categoryId)
                );
            }
        }

        return $breadcrumbs;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function pointOfSale()
    {
        return $this->belongsTo(PointOfSale::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    protected static function booted()
    {
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
    }
}
