<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Country extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'country_iso_code'
    ];

    public function cities() {
        return $this->hasManyThrough(City::class, State::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
