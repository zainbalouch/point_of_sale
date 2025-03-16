<?php

namespace App\Filament\Admin\Resources\TaxResource\Pages;

use App\Filament\Admin\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTax extends ViewRecord
{
    protected static string $resource = TaxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
