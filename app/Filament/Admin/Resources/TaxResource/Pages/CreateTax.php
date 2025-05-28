<?php

namespace App\Filament\Admin\Resources\TaxResource\Pages;

use App\Filament\Admin\Resources\TaxResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreateTax extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = TaxResource::class;
}
