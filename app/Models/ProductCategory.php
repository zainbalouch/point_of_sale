<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class ProductCategory extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'parent_id'
    ];

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

    public function buildBreadcrumbs($categoryId, $prefix = '', $startCategoryId = null)
    {
        $breadcrumbs = [];

        $category = $this->find($categoryId);

        if ($category && $category->id !== $startCategoryId) {
            // Add the category to breadcrumbs only if it has children
            if ($category->childCategories->isNotEmpty()) {
                $breadcrumbs[] = [
                    'id' => $category->id,
                    'name' => $prefix . $category->name,
                ];
            }

            if ($category->parent_id) {
                $breadcrumbs = array_merge(
                    $breadcrumbs,
                    $this->buildBreadcrumbs($category->parent_id, $prefix, $startCategoryId ?: $categoryId)
                );
            }
        }

        return $breadcrumbs;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
