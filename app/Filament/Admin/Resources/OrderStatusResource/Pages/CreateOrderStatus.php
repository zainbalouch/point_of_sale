<?php

namespace App\Filament\Admin\Resources\OrderStatusResource\Pages;

use App\Filament\Admin\Resources\OrderStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreateOrderStatus extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = OrderStatusResource::class;
}
