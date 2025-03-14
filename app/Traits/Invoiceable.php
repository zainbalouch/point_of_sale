<?php

namespace App\Traits;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;

trait Invoiceable
{
    /**
     * Get all invoices for this model
     */
    public function invoices()
    {
        return $this->morphMany(Invoice::class, 'invoiceable');
    }

    /**
     * Create a new invoice for this model
     * 
     * @param array $invoiceData
     * @param array $items Array of item data or Product instances with optional quantity
     * @return Invoice
     */
    public function createInvoice(array $invoiceData = [], array $items = [])
    {
        // Set default invoice number if not provided
        if (!isset($invoiceData['invoice_number'])) {
            $invoiceData['invoice_number'] = Invoice::generateInvoiceNumber();
        }

        // Create the invoice
        $invoice = $this->invoices()->create($invoiceData);

        // Add items if provided
        if (!empty($items)) {
            foreach ($items as $item) {
                $invoiceItem = null;
                
                // Check if the item is a Product instance
                if ($item instanceof Product) {
                    // Create invoice item from product
                    $invoiceItem = InvoiceItem::createFromProduct($item);
                    $invoice->items()->save($invoiceItem);
                } 
                // Check if the item has a product_id reference
                elseif (isset($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        // Create invoice item from product with additional data
                        $invoiceItem = InvoiceItem::createFromProduct($product, $item);
                        $invoice->items()->save($invoiceItem);
                    }
                } 
                // Regular item
                else {
                    $invoiceItem = $invoice->items()->create($item);
                    
                    // If the item contains a reference to another model
                    if (isset($item['itemable_type']) && isset($item['itemable_id'])) {
                        $invoiceItem->itemable_type = $item['itemable_type'];
                        $invoiceItem->itemable_id = $item['itemable_id'];
                        $invoiceItem->save();
                    }
                }
                
                // Calculate amounts for this item if created
                if ($invoiceItem) {
                    $invoiceItem->calculateAmounts();
                }
            }
        }

        // Calculate invoice totals
        $invoice->calculateTotals();

        return $invoice;
    }

    /**
     * Create an invoice for products
     * This specialized method makes it easy to create an invoice from product instances
     * 
     * @param array $invoiceData 
     * @param array $products Array of [product => Product, quantity => int, unit_price => float] 
     * @return Invoice
     */
    public function createProductInvoice(array $invoiceData = [], array $products = [])
    {
        $items = [];
        
        foreach ($products as $productData) {
            $product = $productData['product'] ?? null;
            if (!$product || !($product instanceof Product)) {
                continue;
            }
            
            $quantity = $productData['quantity'] ?? 1;
            $unitPrice = $productData['unit_price'] ?? $product->price;
            
            $itemData = [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
            ];
            
            // Create an item from this product
            $invoiceItem = InvoiceItem::createFromProduct($product, $itemData);
            $items[] = $invoiceItem;
        }
        
        return $this->createInvoice($invoiceData, $items);
    }
} 