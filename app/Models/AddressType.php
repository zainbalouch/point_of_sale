<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class AddressType extends Model
{
    use HasFactory, LogsActivity;

    // Address type constants
    const SHIPPING = 1;
    const BILLING = 2;

    protected $fillable = [
        'name_en',
        'name_ar',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
