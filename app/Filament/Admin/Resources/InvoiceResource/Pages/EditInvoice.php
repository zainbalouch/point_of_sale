<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Pages;

use App\Filament\Admin\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Log::info('Invoice Edit Form Data Before Save - Invoice #' . ($data['number'] ?? 'unknown'), [
            'amount_paid' => $data['amount_paid'] ?? null,
            'amount_left' => $data['amount_left'] ?? null,
            'total' => $data['total'] ?? null,
            'all_data' => $data
        ]);

        return $data;
    }
}
