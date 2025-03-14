<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Addressable;
use App\Traits\Notable;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Addressable, Notable;

    /**
     * Possible buyer types
     */
    const BUYER_TYPE_INDIVIDUAL = 'individual';
    const BUYER_TYPE_COMPANY = 'company';

    protected $fillable = [
        'number',
        'buyer_type',               // Type of buyer: individual or company
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'customer_id',              // Reference to User model if registered
        'company_id',               // Company that owns this order
        'buyer_company_id',         // Reference to buyer's company if applicable
        'buyer_vat_number',         // Buyer's VAT number if applicable
        'has_valid_vat_number',     // Whether the buyer's VAT number is validated
        'vat_verified_at',          // When VAT was verified
        'order_status_id',
        'shipping_fee',
        'subtotal',
        'tax',
        'total',
        'payment_method_id',
        'currency_id',
        'country_id',              // Billing country
        'state_id',                // Billing state
        'estimated_delivery_at',
        'delivered_at',
        'shipped_at',
    ];

    protected $casts = [
        'estimated_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'shipped_at' => 'datetime',
        'vat_verified_at' => 'datetime',
        'has_valid_vat_number' => 'boolean',
    ];

    /**
     * Get the company associated with this order
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the customer associated with this order
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
    
    /**
     * Get the buyer's company if applicable
     */
    public function buyerCompany()
    {
        return $this->belongsTo(Company::class, 'buyer_company_id');
    }

    /**
     * Get the status of this order
     */
    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

    /**
     * Get the payment method used for this order
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    /**
     * Get the currency used for this order
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    
    /**
     * Get the country for this order
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    
    /**
     * Get the state for this order
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * Get the items in this order
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Money accessors and mutators
     */
    public function getShippingFeeAttribute($value)
    {
        return $value / 100;
    }

    public function setShippingFeeAttribute($value)
    {
        $this->attributes['shipping_fee'] = $value * 100;
    }

    public function getSubtotalAttribute($value)
    {
        return $value / 100;
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $value * 100;
    }

    public function getTaxAttribute($value)
    {
        return $value / 100;
    }

    public function setTaxAttribute($value)
    {
        $this->attributes['tax'] = $value * 100;
    }

    public function getTotalAttribute($value)
    {
        return $value / 100;
    }

    public function setTotalAttribute($value)
    {
        $this->attributes['total'] = $value * 100;
    }
    
    /**
     * Set the buyer's VAT number and validate it
     * 
     * @param string $vatNumber
     * @return bool Whether the VAT number is valid
     */
    public function setVatNumber($vatNumber)
    {
        $this->buyer_vat_number = $vatNumber;
        
        // If company ID is set, use the company's VAT validation
        if ($this->company_id) {
            $company = Company::find($this->company_id);
            if ($company) {
                $isValid = $company->isValidVatNumber($vatNumber);
                $this->has_valid_vat_number = $isValid;
                if ($isValid) {
                    $this->vat_verified_at = now();
                }
                $this->save();
                return $isValid;
            }
        }
        
        // Default validation logic if company can't validate
        $this->has_valid_vat_number = false;
        $this->save();
        return false;
    }
    
    /**
     * Check if the buyer is a company
     * 
     * @return bool
     */
    public function isBuyerCompany()
    {
        return $this->buyer_type === self::BUYER_TYPE_COMPANY || !empty($this->buyer_company_id);
    }
    
    /**
     * Get the appropriate tax rate for this order based on buyer location and VAT status
     * 
     * @return TaxRate|null
     */
    public function getApplicableTaxRate()
    {
        if (!$this->company_id) {
            return null;
        }
        
        $company = Company::find($this->company_id);
        if (!$company) {
            return null;
        }
        
        $country = $this->country;
        $state = $this->state;
        
        return $company->findApplicableTaxRate(
            $country,
            $state,
            $this->has_valid_vat_number
        );
    }

    /**
     * Calculate the totals for this order based on its items
     */
    public function calculateTotals()
    {
        $items = $this->items;
        
        $subtotal = $items->sum('total_price');
        
        // Get tax amount from items directly instead of applying a global rate
        $tax = $items->sum('tax_amount');
        
        $total = $subtotal + $this->shipping_fee;

        $this->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
        ]);
        
        return $this;
    }

    /**
     * Add a product to this order
     * 
     * @param Product $product
     * @param int $quantity
     * @param float|null $unitPrice
     * @param int|null $taxRateId
     * @return OrderItem
     */
    public function addProduct(Product $product, int $quantity = 1, float $unitPrice = null, int $taxRateId = null)
    {
        // If no specific tax rate ID is provided, get the applicable one
        if (!$taxRateId) {
            $taxRate = $this->getApplicableTaxRate();
            $taxRateId = $taxRate ? $taxRate->id : null;
        }
        
        $itemData = [
            'order_id' => $this->id,
            'quantity' => $quantity,
            'company_id' => $this->company_id, // Pass the company_id for tax rate lookup
            'tax_rate_id' => $taxRateId,
            'has_valid_vat_number' => $this->has_valid_vat_number,
        ];
        
        if ($unitPrice !== null) {
            $itemData['unit_price'] = $unitPrice;
        }
        
        $orderItem = OrderItem::createFromProduct($product, $itemData);
        $this->items()->save($orderItem);
        $orderItem->calculateTotal();
        
        return $orderItem;
    }

    /**
     * Scope to filter orders by company
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }
    
    /**
     * Scope to filter orders by buyer type
     */
    public function scopeByBuyerType($query, $buyerType)
    {
        return $query->where('buyer_type', $buyerType);
    }
    
    /**
     * Scope to get orders with valid VAT numbers
     */
    public function scopeWithValidVat($query)
    {
        return $query->where('has_valid_vat_number', true);
    }

    protected static function boot()
    {
        parent::boot();

        // This event will be fired just before a new order is created
        static::creating(function ($order) {
            // Generate a unique number for the order
            $order->number = static::generateUniqueNumber();
            
            // If no company is set, try to get it from the authenticated user
            if (empty($order->company_id) && auth()->check()) {
                $order->company_id = auth()->user()->company_id;
            }
            
            // Set default buyer type if not specified
            if (empty($order->buyer_type)) {
                if (!empty($order->buyer_company_id) || !empty($order->buyer_vat_number)) {
                    $order->buyer_type = self::BUYER_TYPE_COMPANY;
                } else {
                    $order->buyer_type = self::BUYER_TYPE_INDIVIDUAL;
                }
            }
        });
    }

    /**
     * Generate a unique order number
     */
    private static function generateUniqueNumber()
    {
        $prefix = config('shop.order_number_prefix', 'ORD');
        return $prefix . '-' . date('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
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
