<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Address extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'address_type_id',
        'contact_person_name',
        'contact_person_phone',
        'street',
        'city',
        'state',
        'postal_code',
        'country',
        'latitude',
        'longitude',
        'details',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function addressType()
    {
        return $this->belongsTo(AddressType::class);
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
