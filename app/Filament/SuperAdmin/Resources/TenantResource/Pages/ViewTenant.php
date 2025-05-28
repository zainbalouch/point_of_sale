<?php

namespace App\Filament\SuperAdmin\Resources\TenantResource\Pages;

use App\Filament\SuperAdmin\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Actions;
use Illuminate\Support\Str; // For string manipulation
use Filament\Resources\Pages\ViewRecord;

class ViewTenant extends ViewRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $tenant = $this->record; // $this->record is the current Tenant model instance

        if ($tenant instanceof Tenant) {
            // Assuming the Tenant model has a relationship `domains()` that returns its associated domains.
            // And we take the first domain. If a tenant can have multiple, you might need specific logic.
            $domainModel = $tenant->domains()->first();

            if ($domainModel) {
                $fullDomain = $domainModel->domain; // The full domain string, e.g., 'mytenant.example.com'
                $centralDomain = env('CENTRAL_DOMAIN');

                if (!empty($centralDomain)) {
                    // Construct the part to remove, ensuring it starts with a dot if centralDomain is not empty
                    $suffixToRemove = '.' . $centralDomain;
                    if (Str::endsWith($fullDomain, $suffixToRemove)) {
                        $subdomain = Str::beforeLast($fullDomain, $suffixToRemove);
                        $data['domain'] = $subdomain; // 'domain' is the name of our TextInput field
                    } else {
                        // If the domain doesn't end with .CENTRAL_DOMAIN, maybe it's a custom/vanity domain.
                        // Or CENTRAL_DOMAIN changed. For now, we'll use the full domain as a fallback.
                        $data['domain'] = $fullDomain;
                    }
                } else {
                    // If CENTRAL_DOMAIN is not set, we can't reliably extract a subdomain part.
                    // So, use the full domain as is. The suffix on the form field will also be empty.
                    $data['domain'] = $fullDomain;
                }
            } else {
            }
        }
        return $data;
    }
}
