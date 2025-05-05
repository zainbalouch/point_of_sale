<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\BusinessMetricsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('quickReservation')
                ->label('Create Order')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary')
                ->url(route('filament.admin.resources.orders.create'))
                ->button(),

            \Filament\Actions\Action::make('quickReservation')
                ->label('Create Invoice')
                ->icon('heroicon-o-document-text')
                ->color('primary')
                ->url(route('filament.admin.resources.invoices.create'))
                ->button(),
        ];
    }

    public function getWidgets(): array
    {
        return [
            BusinessMetricsWidget::class,
        ];
    }
}
