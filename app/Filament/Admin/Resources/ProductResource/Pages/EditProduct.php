<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
