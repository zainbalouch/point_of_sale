<?php

namespace App\Filament\Admin\Resources\InvoiceResource\Pages;

use App\Filament\Admin\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Facades\Filament;
use Illuminate\Contracts\View\View;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('printInvoice')
                ->label(__('Print Invoice'))
                ->icon('heroicon-o-printer')
                ->url(fn ($record) => route('invoice.show', $record))
                ->extraAttributes([
                    'onclick' => "event.preventDefault(); openPrintPreview(this.href)"
                ])
                ->visible(function ($record) {
                    $user = Filament::auth()->user();
                    return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                }),
        ];
    }

    /**
     * Include the print script component in the view
     */
    public function getFooter(): View
    {
        return view('components.print-script');
    }
}
