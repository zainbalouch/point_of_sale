<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Property extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'name',
        'description',
        'space_sqm',
        'max_guests',
        'number_of_rooms',
        'price_per_night',
        'is_listed',
        'property_type_id',
        'image_url',
        'latitude',
        'longitude',
        'city_id',
        'full_address',
        'postal_code',
    ];

    // Define an accessor to format the price_per_night attribute when retrieving it
    public function getPricePerNightAttribute($value)
    {
        // Convert the price_per_night from Bani to RON and Halala format
        // return number_format($value / 100, 2);

        return $value / 100;
    }

    // Define a mutator to convert and store the price_per_night attribute as Bani
    public function setPricePerNightAttribute($value)
    {
        // Convert the price_per_night from RON and Bani format to Bani
        $this->attributes['price_per_night'] = (int) ($value * 100);
    }

    public function getImageUrlAttribute() {
        $imageName = $this->attributes['image_url'];

        // Check if the image exists in the storage or public directory
        if (Storage::disk('public')->exists('images/properties/' . $imageName)) {
            return asset('images/properties/' . $imageName);
        }

        // If the image doesn't exist, you can return a default image or null
        return asset('storage/images/properties/default.png'); // how to return the storage path
    }

    public function scopeWhenSearch($query, $search) {
        return $query->when($search, function($q) use ($search) {
            return $q->where('name', 'like', '%' . $search . '%');
        });
    }

    public function propertyType() {
        return $this->belongsTo(PropertyType::class);
    }

    public function wishListByUsers() {
        return $this->belongsToMany(User::class, 'user_wish_list_property', 'property_id', 'user_id');
    }

    public function city() {
        return $this->belongsTo(City::class);
    }
    
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
}
