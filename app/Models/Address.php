<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Address extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'address_type_id',
        'addressable_id',
        'addressable_type',
        'street',
        'postal_code',
        'country_id',
        'contact_person_full_name',
        'contact_person_phone',
        'latitude',
        'longitude',
        'details',
    ];

    /**
     * Get the parent addressable model.
     * 
     * This could be one of several models:
     * - Company
     * - User
     * - Customer
     */
    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the address type associated with the address.
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(AddressType::class, 'address_type_id');
    }

    /**
     * Get the country associated with the address.
     */
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute(): string
    {
        return $this->street . ', ' . $this->postal_code . ', ' . $this->country->name;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}