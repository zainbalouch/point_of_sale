<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

trait Orderable
{
    /**
     * Get all orders for this model
     */
    public function orders()
    {
        return $this->morphMany(Order::class, 'orderable');
    }

    /**
     * Create a new order for this model
     * 
     * @param array $orderData
     * @param array $items Array of item data or Product instances with optional quantity
     * @return Order
     */
    public function createOrder(array $orderData = [], array $items = [])
    {
        // Create the order
        $order = $this->orders()->create($orderData);

        // Add items if provided
        if (!empty($items)) {
            foreach ($items as $item) {
                $orderItem = null;
                
                // Check if the item is a Product instance
                if ($item instanceof Product) {
                    // Create order item from product
                    $orderItem = OrderItem::createFromProduct($item);
                    $order->items()->save($orderItem);
                } 
                // Check if the item has a product_id reference
                elseif (isset($item['product_id'])) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        // Create order item from product with additional data
                        $orderItem = OrderItem::createFromProduct($product, $item);
                        $order->items()->save($orderItem);
                    }
                } 
                // Regular item
                else {
                    $orderItem = $order->items()->create($item);
                }
                
                // Calculate amounts for this item if created
                if ($orderItem) {
                    $orderItem->calculateTotal();
                }
            }
        }

        // Calculate order totals
        $order->calculateTotals();

        return $order;
    }

    /**
     * Create an order for products
     * This specialized method makes it easy to create an order from product instances
     * 
     * @param array $orderData 
     * @param array $products Array of [product => Product, quantity => int, unit_price => float] 
     * @return Order
     */
    public function createProductOrder(array $orderData = [], array $products = [])
    {
        $items = [];
        
        foreach ($products as $productData) {
            $product = $productData['product'] ?? null;
            if (!$product || !($product instanceof Product)) {
                continue;
            }
            
            $quantity = $productData['quantity'] ?? 1;
            $unitPrice = $productData['unit_price'] ?? $product->price;
            $discount = $productData['discount_amount'] ?? 0;
            
            $itemData = [
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'discount_amount' => $discount,
            ];
            
            // Create an item from this product
            $orderItem = OrderItem::createFromProduct($product, $itemData);
            $items[] = $orderItem;
        }
        
        return $this->createOrder($orderData, $items);
    }
} 