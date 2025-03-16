<?php

namespace App\Filament\Admin\Resources\AddressTypeResource\Pages;

use App\Filament\Admin\Resources\AddressTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAddressTypes extends ListRecords
{
    protected static string $resource = AddressTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
