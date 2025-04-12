<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Pages;

use App\Filament\Admin\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // Actions\Action::make('invoice_template_settings')
            //     ->label('Invoice Template Settings')
            //     ->icon('heroicon-o-document-text')
            //     ->url(route('filament.admin.pages.invoice-template-settings')),
        ];
    }
}
