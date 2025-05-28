<?php

namespace App\Filament\Admin\Resources\SettingResource\Pages;

use App\Filament\Admin\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Traits\HasCloseAndRedirect;

class CreateSetting extends CreateRecord
{
    use HasCloseAndRedirect;
    protected static string $resource = SettingResource::class;
}
