<?php

namespace App\Filament\Admin\Resources\PointOfSaleResource\Pages;

use App\Filament\Admin\Resources\PointOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPointOfSale extends EditRecord
{
    protected static string $resource = PointOfSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
