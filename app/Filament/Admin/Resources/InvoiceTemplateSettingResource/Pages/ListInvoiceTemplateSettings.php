<?php

namespace App\Filament\Admin\Resources\InvoiceTemplateSettingResource\Pages;

use App\Filament\Admin\Resources\InvoiceTemplateSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoiceTemplateSettings extends ListRecords
{
    protected static string $resource = InvoiceTemplateSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
