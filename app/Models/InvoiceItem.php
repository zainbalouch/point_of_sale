<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Traits\Notable;
use App\Models\User;

class InvoiceItem extends Model
{
    use HasFactory, LogsActivity, SoftDeletes, Notable;

    protected $fillable = [
        'invoice_id',
        'invoiceable_item_type',
        'invoiceable_item_id',
        'product_name_en',
        'product_name_ar',
        'product_description_en',
        'product_description_ar',
        'product_sku',
        'product_code',
        'quantity',
        'unit_price',
        'tax_rate_id',
        'tax_rate_snapshot',
        'tax_rate_name_snapshot',
        'tax_amount',
        'discount_amount',
        'subtotal',
        'total',
    ];

    /**
     * Get the invoice this item belongs to
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the invoiceable item entity (product, order item, etc)
     */
    public function invoiceableItem()
    {
        return $this->morphTo();
    }

    /**
     * Get the tax rate associated with this item
     */
    public function taxRate()
    {
        return $this->belongsTo(TaxRate::class);
    }

    /**
     * Create an invoice item from a product
     * This takes a snapshot of the product data at invoice creation time
     *
     * @param Product $product
     * @param array $itemData Additional data for the invoice item
     * @return InvoiceItem
     */
    public static function createFromProduct(Product $product, array $itemData = [])
    {
        // Determine which tax rate to use
        $taxRateId = $itemData['tax_rate_id'] ?? null;
        
        // If no specific tax rate is provided, try to find the default one
        if (!$taxRateId) {
            $companyId = $itemData['company_id'] ?? null;
            if ($companyId) {
                // Most minimal context possible
                $context = [
                    'date' => $itemData['date'] ?? now()
                ];
                
                // Add customer if available
                if (!empty($itemData['customer_id'])) {
                    $customer = User::find($itemData['customer_id']);
                    if ($customer) {
                        $context['customer'] = $customer;
                    }
                }
                
                $taxRate = TaxRate::findApplicable($companyId, $context);
                $taxRateId = $taxRate ? $taxRate->id : null;
            }
        }
        
        // Get tax rate information for snapshot
        $taxRateSnapshot = 0;
        $taxRateNameSnapshot = null;
        
        if ($taxRateId) {
            $taxRate = TaxRate::find($taxRateId);
            if ($taxRate) {
                $taxRateSnapshot = $taxRate->rate;
                $taxRateNameSnapshot = $taxRate->name;
            }
        }
        
        // Extract product data for snapshot
        $productData = [
            'product_name_en' => $product->name_en,
            'product_name_ar' => $product->name_ar,
            'product_description_en' => $product->description_en,
            'product_description_ar' => $product->description_ar,
            'product_sku' => $product->sku,
            'product_code' => $product->code,
            'unit_price' => $itemData['unit_price'] ?? $product->price,
            'tax_rate_id' => $taxRateId,
            'tax_rate_snapshot' => $taxRateSnapshot,
            'tax_rate_name_snapshot' => $taxRateNameSnapshot,
        ];

        // Merge product data with additional invoice item data
        $mergedData = array_merge($productData, $itemData);

        // Set the polymorphic relationship
        $mergedData['invoiceable_item_type'] = get_class($product);
        $mergedData['invoiceable_item_id'] = $product->id;

        return new self($mergedData);
    }

    /**
     * Create an invoice item from an order item
     * This takes the snapshot data from the order item
     *
     * @param OrderItem $orderItem
     * @param array $itemData Additional data for the invoice item
     * @return InvoiceItem
     */
    public static function createFromOrderItem(OrderItem $orderItem, array $itemData = [])
    {
        // Extract data from order item
        $orderItemData = [
            'product_name_en' => $orderItem->product_name_en,
            'product_name_ar' => $orderItem->product_name_ar,
            'product_description_en' => $orderItem->product_description_en,
            'product_description_ar' => $orderItem->product_description_ar,
            'product_sku' => $orderItem->product_sku,
            'product_code' => $orderItem->product_code,
            'quantity' => $itemData['quantity'] ?? $orderItem->quantity,
            'unit_price' => $itemData['unit_price'] ?? $orderItem->unit_price,
            'tax_rate_id' => $orderItem->tax_rate_id,
            'tax_rate_snapshot' => $orderItem->tax_rate_snapshot,
            'tax_rate_name_snapshot' => $orderItem->tax_rate_name_snapshot,
            'discount_amount' => $itemData['discount_amount'] ?? $orderItem->discount_amount,
        ];

        // Merge order item data with additional invoice item data
        $mergedData = array_merge($orderItemData, $itemData);

        // Set the polymorphic relationship to the order item
        $mergedData['invoiceable_item_type'] = get_class($orderItem);
        $mergedData['invoiceable_item_id'] = $orderItem->id;

        return new self($mergedData);
    }

    /**
     * Money accessors and mutators
     */
    public function getUnitPriceAttribute($value)
    {
        return $value / 100;
    }

    public function setUnitPriceAttribute($value)
    {
        $this->attributes['unit_price'] = $value * 100;
    }

    /**
     * Tax rate accessors and mutators (stored as basis points, displayed as percentage)
     * For example: 8.25% is stored as 825
     */
    public function getTaxRateAttribute()
    {
        return $this->tax_rate_snapshot / 100;
    }

    public function getTaxRateSnapshotAttribute($value)
    {
        return $value;
    }

    public function setTaxRateSnapshotAttribute($value)
    {
        $this->attributes['tax_rate_snapshot'] = $value;
    }

    public function getTaxAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setTaxAmountAttribute($value)
    {
        $this->attributes['tax_amount'] = $value * 100;
    }

    public function getDiscountAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setDiscountAmountAttribute($value)
    {
        $this->attributes['discount_amount'] = $value * 100;
    }

    public function getSubtotalAttribute($value)
    {
        return $value / 100;
    }

    public function setSubtotalAttribute($value)
    {
        $this->attributes['subtotal'] = $value * 100;
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
     * Calculate the amounts for this item
     */
    public function calculateAmounts()
    {
        // Calculate raw subtotal (quantity * unit price)
        $rawSubtotal = $this->quantity * $this->unit_price;
        
        // Calculate tax amount based on tax rate - using the accessor ensures we get the percentage value
        $taxAmount = $rawSubtotal * ($this->tax_rate / 100);
        
        // Assume discount_amount is set separately
        
        // Calculate total
        $total = $rawSubtotal + $taxAmount - $this->discount_amount;

        $this->update([
            'subtotal' => $rawSubtotal,
            'tax_amount' => $taxAmount,
            'total' => $total
        ]);
        
        // Make sure to recalculate invoice totals
        if ($this->invoice) {
            $this->invoice->calculateTotals();
        }
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
