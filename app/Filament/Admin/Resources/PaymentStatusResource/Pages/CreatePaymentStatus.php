<?php

namespace App\Filament\Admin\Resources\PaymentStatusResource\Pages;

use App\Filament\Admin\Resources\PaymentStatusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreatePaymentStatus extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = PaymentStatusResource::class;
}
