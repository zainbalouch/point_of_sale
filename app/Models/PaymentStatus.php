<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

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
    ];

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
}
