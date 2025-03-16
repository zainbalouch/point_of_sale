<?php

namespace App\Filament\Admin\Resources\AddressTypeResource\Pages;

use App\Filament\Admin\Resources\AddressTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddressType extends EditRecord
{
    protected static string $resource = AddressTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
