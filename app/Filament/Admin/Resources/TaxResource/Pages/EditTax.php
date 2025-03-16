<?php

namespace App\Filament\Admin\Resources\TaxResource\Pages;

use App\Filament\Admin\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTax extends EditRecord
{
    protected static string $resource = TaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
