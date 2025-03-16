<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

    public function addressable()
    {
        return $this->morphTo();
    }

    public function type()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function getFullAddressAttribute()
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