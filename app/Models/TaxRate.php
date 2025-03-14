<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class TaxRate extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'company_id',
        'name',
        'rate',
        'vat_type',
        'requires_vat_number',
        'is_default',
        'is_active',
        'effective_from',
        'effective_until',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
        'requires_vat_number' => 'boolean',
        'effective_from' => 'date',
        'effective_until' => 'date',
    ];

    /**
     * Get the company that owns this tax rate
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get tax rate as a percentage
     * Converts from basis points (stored as integer) to percentage
     */
    public function getRatePercentAttribute()
    {
        return $this->rate / 100;
    }

    /**
     * Set tax rate from percentage
     * Converts from percentage to basis points (stored as integer)
     */
    public function setRateAttribute($value)
    {
        // If the value is already in the correct format (e.g., already multiplied), don't multiply again
        // We determine this by checking if it's a decimal < 100 (likely a percentage) or >= 100 (likely basis points)
        if ($value < 100 && !is_int($value)) {
            $this->attributes['rate'] = $value * 100;
        } else {
            $this->attributes['rate'] = $value;
        }
    }

    /**
     * Format the rate as a percentage string
     */
    public function getFormattedRateAttribute()
    {
        return number_format($this->rate_percent, 2) . '%';
    }
    
    /**
     * Check if this tax rate is applicable for a given context
     * 
     * @param array $context Contains information about the customer
     * @return bool
     */
    public function isApplicable(array $context = [])
    {
        // If not active, not applicable
        if (!$this->is_active) {
            return false;
        }
        
        // Check if rate is effective at current date
        $currentDate = $context['date'] ?? now();
        if (($this->effective_from && $currentDate < $this->effective_from) || 
            ($this->effective_until && $currentDate > $this->effective_until)) {
            return false;
        }
        
        // Ultra simplified VAT check - only check if this tax rate requires VAT number
        if ($this->requires_vat_number) {
            $customer = $context['customer'] ?? null;
            
            // Tax rate requires a customer with company that has a VAT number
            if (!$customer || !$customer->company || empty($customer->company->vat_number)) {
                return false;
            }
        }
        
        return true;
    }
    
    /**
     * Calculate the tax amount for a given subtotal
     * 
     * @param float $subtotal The subtotal to calculate tax on
     * @param array $context Contains information about the customer
     * @return float
     */
    public function calculateTaxAmount($subtotal, array $context = [])
    {
        if (!$this->isApplicable($context)) {
            return 0.0;
        }
        
        return $subtotal * ($this->rate_percent / 100);
    }

    /**
     * Scope query to only include active tax rates
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope query to only include tax rates for the given company
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Scope query to only include default tax rates
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope query to include only tax rates that are effective at the given date
     */
    public function scopeEffectiveAt($query, $date = null)
    {
        $date = $date ?? now();
        
        return $query->where(function($query) use ($date) {
            $query->where(function($query) use ($date) {
                $query->whereNull('effective_from')
                      ->whereNull('effective_until');
            })->orWhere(function($query) use ($date) {
                $query->whereNull('effective_from')
                      ->whereDate('effective_until', '>=', $date);
            })->orWhere(function($query) use ($date) {
                $query->whereDate('effective_from', '<=', $date)
                      ->whereNull('effective_until');
            })->orWhere(function($query) use ($date) {
                $query->whereDate('effective_from', '<=', $date)
                      ->whereDate('effective_until', '>=', $date);
            });
        });
    }

    /**
     * Find the applicable tax rate for a company
     * 
     * @param int $companyId Company that owns the tax rate
     * @param array $context Contains information about the customer
     * @return TaxRate|null
     */
    public static function findApplicable($companyId, array $context = [])
    {
        $query = self::forCompany($companyId)
            ->active()
            ->effectiveAt($context['date'] ?? now());
            
        // Try to find a default tax rate first
        $defaultRate = (clone $query)->default()->first();
        if ($defaultRate && $defaultRate->isApplicable($context)) {
            return $defaultRate;
        }
        
        // If no default rate, get the first applicable rate
        $rates = $query->get();
        foreach ($rates as $rate) {
            if ($rate->isApplicable($context)) {
                return $rate;
            }
        }
        
        return null;
    }

    /**
     * Get the activity log options
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['*'])
            ->logOnlyDirty();
    }
} 