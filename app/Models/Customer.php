<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Customer extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'vat_number',
        'address',
        'company_id',
        'point_of_sale_id',
        'is_active',
        'meta',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
        'meta' => 'array',
    ];

    /**
     * Get the company that the customer belongs to.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get all orders for the customer.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the customer's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the addresses associated with the customer.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the notes associated with the customer.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
    }

    /**
     * Get the point of sale that the customer belongs to.
     */
    public function pointOfSale(): BelongsTo
    {
        return $this->belongsTo(PointOfSale::class);
    }

    /**
     * Get the activity log options for the model.
     */
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
                    $builder->whereHas('pointOfSale', function ($query) {
                        $query->where('is_active', true);
                    })->where('point_of_sale_id', $user->point_of_sale_id);
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
                    if (!$model->pointOfSale || !$model->pointOfSale->is_active) {
                        abort(403, 'Cannot update record for inactive point of sale');
                    }
                } elseif ($user->company_id) {
                    if (!$model->company || !$model->company->is_active) {
                        abort(403, 'Cannot update record for inactive company');
                    }
                }
            }
        });

        static::deleting(function ($model) {
            $user = Auth::user();
            if ($user) {
                if ($user->point_of_sale_id) {
                    if (!$model->pointOfSale || !$model->pointOfSale->is_active) {
                        abort(403, 'Cannot delete record for inactive point of sale');
                    }
                } elseif ($user->company_id) {
                    if (!$model->company || !$model->company->is_active) {
                        abort(403, 'Cannot delete record for inactive company');
                    }
                }
            }
        });
    }
}
