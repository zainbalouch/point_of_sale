<?php

namespace App\Filament\SuperAdmin\Resources\TenantResource\Pages;

use App\Filament\SuperAdmin\Resources\TenantResource;
use App\Models\Tenant; // Assuming Tenant model is App\Models\Tenant
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str; // For string manipulation
use Illuminate\Support\Facades\DB; // For database operations
use Illuminate\Support\Facades\Validator; // Added for Validator Facade
use Illuminate\Validation\Rule; // For validation rules
use Illuminate\Validation\ValidationException; // For throwing validation exceptions
use Filament\Notifications\Notification; // For sending notifications

class EditTenant extends EditRecord
{
    protected static string $resource = TenantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
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

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $tenant = $this->record; // Current tenant being edited

        // 'domain' in $data is the submitted subdomain value from the form
        if (isset($data['domain']) && $tenant instanceof Tenant) {
            $newSubdomain = $data['domain'];
            $centralDomain = env('CENTRAL_DOMAIN');

            if (empty($centralDomain)) {
                $errorMsg = 'CENTRAL_DOMAIN is not configured in your .env file.';
                Notification::make()->title('Configuration Error')->body($errorMsg)->danger()->send();
                throw ValidationException::withMessages(['domain' => $errorMsg]);
            }

            $newFullDomain = $newSubdomain . '.' . $centralDomain;

            // Get the current domain model to check if the domain string has actually changed
            // and to ignore it in uniqueness validation if it hasn't.
            $currentDomainModel = $tenant->domains()->first();

            if (!$currentDomainModel) {
                // This case should ideally not happen if the form was filled correctly from an existing domain.
                // But as a fallback, if no existing domain, we might treat it as creating a new one (though this page is EditRecord)
                // Or, more safely, throw an error or prevent changes if the original domain context is lost.
                $errorMsg = 'Original domain record not found. Cannot update domain.';
                Notification::make()->title('Error')->body($errorMsg)->danger()->send();
                throw ValidationException::withMessages(['domain' => $errorMsg]);
            }

            // Only proceed with validation and update if the domain has actually changed.
            if ($currentDomainModel->domain !== $newFullDomain) {
                // Validate uniqueness of the new full domain, ignoring the current domain ID
                $validator = Validator::make(
                    ['domain_to_validate' => $newFullDomain],
                    ['domain_to_validate' => Rule::unique('domains', 'domain')->ignore($currentDomainModel->id)]
                );

                if ($validator->fails()) {
                    $errorMessage = 'The generated domain (\'' . $newFullDomain . '\') already exists.';
                    Notification::make()->title('Validation Error')->body($errorMessage)->danger()->send();
                    throw ValidationException::withMessages(['domain' => $errorMessage]);
                }

                // Update the existing domain record
                try {
                    DB::table('domains')->where('id', $currentDomainModel->id)->update([
                        'domain' => $newFullDomain,
                        'updated_at' => now(),
                    ]);
                    Notification::make()->title('Domain Updated')->body('The domain has been successfully updated to: ' . $newFullDomain)->success()->send();
                } catch (\Exception $e) {
                    $errorMsg = 'Error updating domain record: ' . $e->getMessage();
                    Notification::make()->title('Database Error')->body($errorMsg)->danger()->send();
                    // Optionally rethrow or wrap in a ValidationException if appropriate
                    // For now, we send a notification and log, but allow tenant save to proceed if other fields changed.
                }
            } else {
            }
        }

        // Remove 'domain' from $data before returning, as it's not a field on the Tenant model itself.
        unset($data['domain']);
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index', panel: 'super_admin');
    }
}
