<?php

namespace App\Filament\Admin\Resources\ProductCategoryResource\Pages;

use App\Filament\Admin\Resources\ProductCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreateProductCategory extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = ProductCategoryResource::class;
}
