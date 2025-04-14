<?php

namespace App\Filament\Admin\Resources\PointOfSaleResource\Pages;

use App\Filament\Admin\Resources\PointOfSaleResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePointOfSale extends CreateRecord
{
    protected static string $resource = PointOfSaleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['company_id'] = Auth::user()->company_id;
        return $data;
    }
}
