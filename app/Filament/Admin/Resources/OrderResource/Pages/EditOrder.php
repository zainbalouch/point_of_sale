<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Filament\Admin\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Calculate the balance left
        $total = floatval($data['total'] ?? 0);
        $amountPaid = floatval($data['amount_paid'] ?? 0);
        $data['balance_left'] = number_format($total - $amountPaid, 2, '.', '');

        return $data;
    }
}
