<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Tax extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name_en',
        'name_ar',
        'type',
        'amount',
        'company_id',
        'is_active',
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

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
            ->withTimestamps()
            ->withPivot('deleted_at');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
