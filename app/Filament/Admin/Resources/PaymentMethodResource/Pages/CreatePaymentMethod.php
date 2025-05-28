<?php

namespace App\Filament\Admin\Resources\PaymentMethodResource\Pages;

use App\Filament\Admin\Resources\PaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreatePaymentMethod extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = PaymentMethodResource::class;
}
