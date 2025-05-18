<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AddressType extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name_en',
        'name_ar',
        'company_id',
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope('company', function (Builder $builder) {
    //         $user = Auth::user();
    //         if ($user && $user->company_id) {
    //             $builder->whereHas('company', function ($query) {
    //                 $query->where('is_active', true);
    //             })->where('company_id', $user->company_id);
    //         }
    //     });
    // }

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
