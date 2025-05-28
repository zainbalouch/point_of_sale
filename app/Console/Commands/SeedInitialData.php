<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\initialDataSeeder;

class SeedInitialData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-initial-data {--company_name=} {--tax_number=} {--tenant_id=} {--email=} {--password=} {--phone=} {--address=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeds initial data and generates permissions for tenants, with optional overrides.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $companyName = $this->option('company_name');
        $taxNumber = $this->option('tax_number');
        $tenantId = $this->option('tenant_id');
        $email = $this->option('email');
        $password = $this->option('password');
        $phone = $this->option('phone');
        $address = $this->option('address');

        if ($companyName) {
            $this->info("Using company name: {$companyName} for seeding.");
            initialDataSeeder::$companyNameOverride = $companyName;
        }
        if ($taxNumber) {
            $this->info("Using tax number: {$taxNumber} for seeding.");
            initialDataSeeder::$taxNumberOverride = $taxNumber;
        }
        if ($email) {
            $this->info("Using email: {$email} for seeding.");
            initialDataSeeder::$emailOverride = $email;
        }
        if ($password) {
            $this->info("Using provided password for admin user."); // Avoid logging password
            initialDataSeeder::$passwordOverride = $password;
        }
        if ($phone) {
            $this->info("Using phone: {$phone} for seeding.");
            initialDataSeeder::$phoneOverride = $phone;
        }
        if ($address) {
            $this->info("Using address: {$address} for seeding.");
            initialDataSeeder::$addressOverride = $address;
        }

        $this->info('Running seeders...');

        $tenantOption = $tenantId ? ['--tenants' => $tenantId] : [];

        Artisan::call('tenants:run', array_merge([
            'commandname' => 'shield:generate',
            '--option' => [
                'option=permissions',
                'all=true',
                'panel=admin'
            ]
        ], $tenantOption));

        Artisan::call('tenants:seed', array_merge([
            '--class' => 'ShieldSeeder'
        ], $tenantOption));

        Artisan::call('tenants:seed', array_merge([
            '--class' => 'initialDataSeeder'
        ], $tenantOption));


        Artisan::call('filament:clear-cached-components');
        Artisan::call('optimize:clear');

        // Reset static properties
        initialDataSeeder::$companyNameOverride = null;
        initialDataSeeder::$taxNumberOverride = null;
        initialDataSeeder::$emailOverride = null;
        initialDataSeeder::$passwordOverride = null;
        initialDataSeeder::$phoneOverride = null;
        initialDataSeeder::$addressOverride = null;

        $this->info('All operations completed successfully.');
        return Command::SUCCESS;
    }
}
