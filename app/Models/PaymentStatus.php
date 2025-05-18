<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PaymentStatus extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
     * Get the payments for the payment status.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the localized name based on the current app locale.
     */
    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        return $locale === 'ar' ? $this->name_ar : $this->name_en;
    }

    /**
     * Get payment status by name.
     */
    public static function getByName(string $name)
    {
        return static::where('name_en', $name)
            ->orWhere('name_ar', $name)
            ->first();
    }

    /**
     * Predefined status constants.
     */
    public const PENDING = 'Pending';
    public const COMPLETED = 'Completed';
    public const FAILED = 'Failed';
    public const REFUNDED = 'Refunded';

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
