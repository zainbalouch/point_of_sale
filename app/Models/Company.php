<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Notable;
use App\Traits\Addressable;

class Company extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Notable, Addressable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'legal_name',
        'tax_id',             // VAT number / Tax ID
        'registration_number', // Company registration number
        'website',
        'email',
        'phone',
        'currency_id',
        'country_id',         // Primary country of operation
        'is_vat_exempt',      // Whether the company is exempt from VAT
        'vat_exemption_reason', // Reason for VAT exemption if applicable
        'logo',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_vat_exempt' => 'boolean',
    ];

    /**
     * Get the country associated with this company
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Get the currency associated with this company
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Get the users associated with this company
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the orders associated with this company
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the invoices associated with this company
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Get the tax rates associated with this company
     */
    public function taxRates()
    {
        return $this->hasMany(TaxRate::class);
    }

    /**
     * Get the default tax rate for this company
     */
    public function defaultTaxRate()
    {
        return $this->taxRates()
            ->where('is_default', true)
            ->whereNull('country_id')
            ->whereNull('state_id')
            ->first();
    }

    /**
     * Get the active default tax rate for this company
     */
    public function activeDefaultTaxRate()
    {
        return $this->taxRates()
            ->where('is_default', true)
            ->where('is_active', true)
            ->whereNull('country_id')
            ->whereNull('state_id')
            ->whereDate('effective_from', '<=', now())
            ->where(function ($query) {
                $query->whereNull('effective_until')
                      ->orWhereDate('effective_until', '>=', now());
            })
            ->first();
    }
    
    /**
     * Find the applicable tax rate for this company based on buyer location
     * 
     * @param Country|null $country The buyer's country
     * @param State|null $state The buyer's state/province
     * @param bool $hasValidVatNumber Whether the buyer has a valid VAT number
     * @return TaxRate|null
     */
    public function findApplicableTaxRate($country = null, $state = null, $hasValidVatNumber = false)
    {
        $countryId = $country ? $country->id : null;
        $stateId = $state ? $state->id : null;
        
        $query = $this->taxRates()
            ->where('is_active', true)
            ->whereDate('effective_from', '<=', now())
            ->where(function ($query) {
                $query->whereNull('effective_until')
                    ->orWhereDate('effective_until', '>=', now());
            });
        
        // If buyer has valid VAT number and we allow VAT exemption, find eligible rates
        if ($hasValidVatNumber) {
            $vatExemptRate = (clone $query)
                ->where('is_exempt_with_valid_vat', true)
                ->where(function($q) use ($countryId, $stateId) {
                    // Try to find country and state specific
                    if ($countryId && $stateId) {
                        $q->where(function($q) use ($countryId, $stateId) {
                            $q->where('country_id', $countryId)
                              ->where('state_id', $stateId);
                        });
                    }
                    // Or just country specific
                    if ($countryId) {
                        $q->orWhere(function($q) use ($countryId) {
                            $q->where('country_id', $countryId)
                              ->whereNull('state_id');
                        });
                    }
                    // Or generic (no country/state)
                    $q->orWhere(function($q) {
                        $q->whereNull('country_id')
                          ->whereNull('state_id');
                    });
                })
                ->first();
            
            if ($vatExemptRate) {
                return $vatExemptRate;
            }
        }
        
        // Try to find a specific match for country and state
        if ($countryId && $stateId) {
            $taxRate = (clone $query)
                ->where('country_id', $countryId)
                ->where('state_id', $stateId)
                ->first();
                
            if ($taxRate) {
                return $taxRate;
            }
        }
        
        // Next try just the country
        if ($countryId) {
            $taxRate = (clone $query)
                ->where('country_id', $countryId)
                ->whereNull('state_id')
                ->first();
                
            if ($taxRate) {
                return $taxRate;
            }
        }
        
        // Finally, use the default tax rate
        return (clone $query)
            ->whereNull('country_id')
            ->whereNull('state_id')
            ->where('is_default', true)
            ->first();
    }
    
    /**
     * Check if the provided VAT number is valid
     * 
     * @param string $vatNumber
     * @return bool
     */
    public function isValidVatNumber($vatNumber)
    {
        // Basic VAT format validation
        $countryCode = substr($vatNumber, 0, 2);
        $numberPart = substr($vatNumber, 2);
        
        // Simple format validation (could be expanded or replaced with API validation)
        if (!ctype_alpha($countryCode) || !ctype_alnum($numberPart)) {
            return false;
        }
        
        // In a real implementation, you would check against a VAT validation API
        // For example: VIES VAT number validation for EU countries
        // This is a simplified implementation
        
        return true;
    }

    /**
     * Format the VAT number with proper spacing and formatting
     * 
     * @param string $vatNumber
     * @return string
     */
    public function formatVatNumber($vatNumber = null)
    {
        $vatNumber = $vatNumber ?? $this->tax_id;
        
        if (empty($vatNumber)) {
            return '';
        }
        
        // Extract country code and format the rest
        $countryCode = strtoupper(substr($vatNumber, 0, 2));
        $numberPart = substr($vatNumber, 2);
        
        // Format based on country standards (simplified example)
        return $countryCode . ' ' . $numberPart;
    }

    /**
     * Scope to only include active companies
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
} 