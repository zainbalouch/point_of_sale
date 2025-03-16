<?php

namespace App\Filament\Admin\Resources\OrderStatusResource\Pages;

use App\Filament\Admin\Resources\OrderStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrderStatus extends ViewRecord
{
    protected static string $resource = OrderStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
} 