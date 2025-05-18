<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\HasInitialData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Company extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HasInitialData;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'legal_name',
        'tax_number',
        'website',
        'email',
        'phone_number',
        'address',
        'logo',
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

    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $user = Auth::user();
            if ($user) {
                if ($user->company_id) {
                    $builder->where('id', $user->company_id);
                } elseif ($user->point_of_sale_id) {
                    $builder->whereHas('pointOfSales', function ($query) use ($user) {
                        $query->where('id', $user->point_of_sale_id);
                    });
                }
            }
        });

        static::created(function ($company) {
            $company->seedInitialData();
        });
    }

    /**
     * Get the users belonging to the company.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the customers belonging to the company.
     */
    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class);
    }

    /**
     * Get the orders associated with the company.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the addresses associated with the company.
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    /**
     * Get the notes associated with the company.
     */
    public function notes(): MorphMany
    {
        return $this->morphMany(Note::class, 'notable');
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
}
