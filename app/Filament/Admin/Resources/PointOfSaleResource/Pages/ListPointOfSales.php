<?php

namespace App\Filament\Admin\Resources\PointOfSaleResource\Pages;

use App\Filament\Admin\Resources\PointOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPointOfSales extends ListRecords
{
    protected static string $resource = PointOfSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
