<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function afterCreate(): void
    {
        $order = $this->record;
        $data = $this->data;

        // Create shipping address if data exists
        if (!empty($data['shipping_address'])) {
            $shippingAddress = $data['shipping_address'];
            $shippingAddress['addressable_type'] = 'App\\Models\\Order';
            $shippingAddress['addressable_id'] = $order->id;
            $order->shippingAddress()->create($shippingAddress);
        }

        // Create billing address if data exists
        if (!empty($data['billing_address'])) {
            $billingAddress = $data['billing_address'];
            $billingAddress['addressable_type'] = 'App\\Models\\Order';
            $billingAddress['addressable_id'] = $order->id;
            $order->billingAddress()->create($billingAddress);
        }

        // Get all items of the order
        $orderItems = $order->items;

        foreach ($orderItems as $item) {
            if ($item->product_id) {
                $product = Product::find($item->product_id);

                if ($product) {
                    // Store original quantity for logging
                    $originalQuantity = $product->quantity;

                    // Reduce the product quantity by the ordered quantity
                    $product->quantity = max(0, $product->quantity - $item->quantity);
                    $product->save();

                    // Log the inventory change
                    Log::info("Product ID {$product->id} quantity reduced from {$originalQuantity} to {$product->quantity} (ordered: {$item->quantity}) from Order #{$order->id}");
                }
            }
        }
    }
}
