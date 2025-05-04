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
        // Get the created order (record is already available in this context)
        $order = $this->record;

        // Log for debugging
        Log::info('Order created: #' . $order->id);

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
