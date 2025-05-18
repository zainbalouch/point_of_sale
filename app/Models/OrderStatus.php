<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class OrderStatus extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
        'company_id',
    ];

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                $builder->whereHas('company', function ($query) {
                    $query->where('is_active', true);
                })->where('company_id', $user->company_id);
            }
        });

        static::retrieved(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(404);
                }
            }
        });

        static::updating(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(403, 'Cannot update record for inactive company');
                }
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user && $user->company_id) {
                if (!$model->company || !$model->company->is_active) {
                    abort(403, 'Cannot delete record for inactive company');
                }
            }
        });
    }

    /**
     * Get the orders with this status.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'order_status_id');
    }

    /**
     * Get the translated name based on the current locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Define activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
