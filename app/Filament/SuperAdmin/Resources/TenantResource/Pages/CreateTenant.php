<?php

namespace App\Filament\SuperAdmin\Resources\TenantResource\Pages;

use App\Filament\SuperAdmin\Resources\TenantResource;
use App\Models\Tenant;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

class CreateTenant extends CreateRecord
{
    protected static string $resource = TenantResource::class;

    // This will hold the full domain string to be created after tenant is made.
    protected ?string $fullDomainToCreate = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $formState = $this->form->getState();
        Log::info('Form state:', ['formState' => $formState]);
        Log::info('Form data:', ['data' => $data]);
        $subdomain = null;
        if (isset($data['domain'])) { // Prefer $data if Filament decides to pass it
            $subdomain = $data['domain'];
        } elseif (isset($formState['domain'])) { // Fallback to formState
            $subdomain = $formState['domain'];
        }

        if ($subdomain !== null) {
            $centralDomain = env('CENTRAL_DOMAIN');
            if (empty($centralDomain)) {
                Notification::make()
                    ->title('Configuration Error')
                    ->body('CENTRAL_DOMAIN is not configured in your .env file.')
                    ->danger()
                    ->send();
                throw ValidationException::withMessages([
                    'domain' => 'CENTRAL_DOMAIN is not configured in your .env file.',
                ]);
            }
            $this->fullDomainToCreate = $subdomain . '.' . $centralDomain;

            $validator = Validator::make(
                ['domain_to_validate' => $this->fullDomainToCreate],
                ['domain_to_validate' => Rule::unique('domains', 'domain')]
            );

            if ($validator->fails()) {
                $errorMessage = 'The generated domain (\'' . $this->fullDomainToCreate . '\') already exists.';

                Notification::make()
                    ->title('Validation Error')
                    ->body($errorMessage)
                    ->danger()
                    ->send();

                throw ValidationException::withMessages([
                    'domain' => $errorMessage,
                ]);
            }
            // Remove 'domain' from $data to ensure it's not passed to Tenant model creation,
            // as it was marked dehydrated(false) in the form.
            unset($data['domain']);
        } else {
        }
        return $data; // Return $data, which should now NOT contain 'domain'.
    }

    protected function afterCreate(): void
    {
        $createdTenant = $this->record;

        if ($this->fullDomainToCreate !== null && $createdTenant instanceof Tenant) {
            try {
                DB::table('domains')->insert([
                    'domain' => $this->fullDomainToCreate,
                    'tenant_id' => $createdTenant->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                // Run the Artisan command after successful domain creation
                try {
                    Artisan::call('app:seed-initial-data', [
                        '--company_name' => $createdTenant->name, // Assuming 'name' is the company name attribute
                        '--tax_number' => $this->data['tax_number'],
                        '--tenant_id' => $createdTenant->id, // Changed from --tenant_id
                        '--email' => $this->data['email'],
                        '--password' => $this->data['password'],
                        '--phone' => $this->data['phone'],
                        '--address' => $this->data['address'],
                    ]);
                    Notification::make()
                        ->title('Tenant Setup Complete')
                        ->body('Tenant, domain, and initial data seeded successfully.')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    // Log this error or send a more specific notification
                    Notification::make()
                        ->title('Seeding Error')
                        ->body('Tenant and domain created, but failed to seed initial data: ' . $e->getMessage())
                        ->warning() // Use warning as tenant itself was created
                        ->send();
                }

            } catch (\Exception $e) {
                Notification::make()
                    ->title('Database Error')
                    ->body('Could not create the domain record: ' . $e->getMessage())
                    ->danger()
                    ->send();
            }
        } else {
            if (!($createdTenant instanceof Tenant)) {
                 Notification::make()
                    ->title('Error')
                    ->body('Tenant creation failed or record is not a valid tenant.')
                    ->danger()
                    ->send();
            } else if (empty($this->fullDomainToCreate)) {
                 Notification::make()
                    ->title('Error')
                    ->body('Domain information was missing after tenant creation.')
                    ->danger()
                    ->send();
            }
        }
        $this->fullDomainToCreate = null; // Reset for next potential creation
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index', panel: 'super_admin');
    }
}
