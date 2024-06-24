<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class State extends Model
{
    use HasFactory, LogsActivity;

    public function cities() {
        return $this->hasMany(City::class);
    }

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
