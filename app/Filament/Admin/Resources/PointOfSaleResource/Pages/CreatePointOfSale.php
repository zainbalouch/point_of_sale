<?php

namespace App\Filament\Admin\Resources\PointOfSaleResource\Pages;

use App\Filament\Admin\Resources\PointOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use App\Filament\Traits\HasCloseAndRedirect;

class CreatePointOfSale extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = PointOfSaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id;
        return $data;
    }
}
