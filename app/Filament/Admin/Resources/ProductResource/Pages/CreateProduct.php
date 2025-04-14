<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        if ($user->company_id) {
            $data['company_id'] = $user->company_id;

            // If no point of sale is selected, get the first one from the company
            if (!isset($data['point_of_sale_id'])) {
                $pointOfSale = \App\Models\PointOfSale::where('company_id', $user->company_id)->first();
                if ($pointOfSale) {
                    $data['point_of_sale_id'] = $pointOfSale->id;
                }
            }
        }
        return $data;
    }
}
