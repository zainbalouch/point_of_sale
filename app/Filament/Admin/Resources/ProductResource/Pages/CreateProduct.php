<?php

namespace App\Filament\Admin\Resources\ProductResource\Pages;

use App\Filament\Admin\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\RedirectResponse;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function getRedirectUrl(): string
    {
        // Check request parameters, hidden inputs, and query parameters for the return_url
        $returnUrl = $this->data['return_url'] ?? request()->input('return_url') ?? request()->query('return_url');

        if ($returnUrl) {
            return $returnUrl;
        }

        return $this->getResource()::getUrl('index');
    }
}
