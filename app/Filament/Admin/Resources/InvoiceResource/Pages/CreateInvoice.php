<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Pages;

use App\Filament\Admin\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $order = \App\Models\Order::find($data['order_id']);
        if ($order) {
            $invoice = InvoiceResource::createInvoiceFromOrder($order, $data);
            $this->record = $invoice;
            return $invoice->toArray();
        }

        return $data;
    }

    protected function handleRecordCreation(array $data): \App\Models\Invoice
    {
        // If we already created the invoice in mutateFormDataBeforeCreate, return it
        if ($this->record) {
            return $this->record;
        }

        // Otherwise, let Filament handle the creation
        return parent::handleRecordCreation($data);
    }

    protected function getRedirectUrl(): string
    {
        // Store the created invoice ID in a one-time session variable
        session()->flash('created_invoice_id', $this->record->id);
        // Redirect to the index page
        return $this->getResource()::getUrl('index');
    }
}
