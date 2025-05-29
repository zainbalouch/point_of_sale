<?php

namespace App\Services;

use App\Models\Tenant;
use Stancl\Tenancy\Contracts\TenantDatabaseManager;
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Exception;

class CpanelDatabaseManager implements TenantDatabaseManager
{
    protected string $cpanelUrl;
    protected string $authorization;
    protected string $dbPrefix;
    protected ?string $connection = null;

    public function __construct()
    {
        $this->cpanelUrl = config('services.cpanel.url');
        $this->authorization = config('services.cpanel.authorization');
        $this->dbPrefix = config('services.cpanel.db_prefix', 'start2_');
    }

    public function setConnection(string $connection): void
    {
        $this->connection = $connection;
    }

    public function createDatabase(TenantWithDatabase $tenant): bool
    {
        try {
            $dbName = $this->getDatabaseName($tenant);
            $username = $this->getUsername($tenant);
            $password = $this->getPassword($tenant);

            Log::info("Attempting to create cPanel database for tenant: {$tenant->id}", [
                'db_name' => $dbName,
                'username' => $username
            ]);

            // Step 1: Create the database
            $this->createCpanelDatabase($dbName);

            // Step 2: Create the user
            $this->createCpanelUser($username, $password);

            // Step 3: Grant privileges
            $this->grantPrivileges($username, $dbName);

            // Step 4: Verify database was actually created
            if (!$this->databaseExists($dbName)) {
                throw new Exception("Database creation appeared successful but database {$dbName} does not exist");
            }

            $createdTenant = Tenant::find($tenant->id);
            Log::info("Created tenant: ");
            Log::info($createdTenant);
            $createdTenant->update([
                'tenancy_db_name' => $dbName,
                'db_name' => $dbName,
                'db_username' => $username,
                'db_password' => $password
            ]);
            Log::info("Updated tenant: ");
            Log::info($createdTenant);

            // Update the tenant connection config in Laravel
            $this->updateTenantConnection($tenant, $dbName, $username, $password);

            Log::info("Successfully created and verified cPanel database for tenant: {$tenant->id}");
            return true;

        } catch (Exception $e) {
            Log::error("Failed to create cPanel database for tenant {$tenant->id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function deleteDatabase(TenantWithDatabase $tenant): bool
    {
        try {
            $dbName = $this->getDatabaseName($tenant);
            $username = $this->getUsername($tenant);

            // Delete database
            $response = Http::withHeaders([
                'Authorization' => $this->authorization
            ])->post($this->cpanelUrl . '/execute/Mysql/delete_database', [
                'name' => $dbName
            ]);

            $this->validateResponse($response, "delete database {$dbName}");

            // Delete user
            $response = Http::withHeaders([
                'Authorization' => $this->authorization
            ])->post($this->cpanelUrl . '/execute/Mysql/delete_user', [
                'name' => $username
            ]);

            $this->validateResponse($response, "delete user {$username}");

            Log::info("Successfully deleted cPanel database for tenant: {$tenant->id}");
            return true;

        } catch (Exception $e) {
            Log::error("Failed to delete cPanel database for tenant {$tenant->id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function databaseExists(string $name): bool
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->authorization
            ])->get($this->cpanelUrl . '/execute/Mysql/list_databases');

            if ($response->successful()) {
                $responseData = $response->json();
                Log::debug("Database list response", ['response' => $responseData]);

                // Extract the databases array from the nested response structure
                $databases = $responseData['data'] ?? [];
                $exists = collect($databases)->contains(function ($item) use ($name) {
                    return $item['database'] === $name;
                });

                Log::info("Database existence check for {$name}: " . ($exists ? 'exists' : 'not found'));
                return $exists;
            }

            Log::warning("Failed to list databases", ['status' => $response->status(), 'body' => $response->body()]);
            return false;
        } catch (Exception $e) {
            Log::error("Failed to check database existence for database {$name}: " . $e->getMessage());
            return false;
        }
    }

    public function makeConnectionConfig(array $baseConfig, string $databaseName): array
    {
        // Find the tenant by the database name stored in the JSON 'data' column
        $tenant = app(config('tenancy.tenant_model'))::where('data->tenancy_db_name', $databaseName)->first();
        Log::info("Tenant for which connection will be made: ");
        Log::info($tenant);
        if (!$tenant) {
            Log::error("makeConnectionConfig: Tenant not found for database {$databaseName} (queried data->tenancy_db_name)");
            return array_merge($baseConfig, [
                'database' => $databaseName,
            ]);
        }

        // Retrieve the stored cPanel username and password from the tenant's 'data' column
        $username = $tenant->db_username ?? null;
        $password = $tenant->db_password ?? null;

        if (!$username || !$password) {
            Log::error("makeConnectionConfig: DB username or password not found in tenant data for {$databaseName}", [
                'tenant_id' => $tenant->id,
                'tenant_data' => $tenant->data,
            ]);
            return array_merge($baseConfig, [
                'database' => $databaseName,
            ]);
        }

        Log::info("makeConnectionConfig: Configuring connection for database '{$databaseName}' with user '{$username}' from tenant data.");

        return array_merge($baseConfig, [
            'database' => $databaseName,
            'username' => $username,
            'password' => $password,
        ]);
    }

    /**
     * Update tenant connection configuration with cPanel credentials
     */
    protected function updateTenantConnection(TenantWithDatabase $tenant, string $dbName, string $username, string $password): void
    {
        // Use the template connection defined in tenancy.php config
        $templateConnectionName = config('tenancy.database.template_tenant_connection');
        if (!$templateConnectionName) {
            // Fallback if not defined, though we set it to 'tenant_template'
            // This fallback logic might ideally point to a safe, inert default if tenancy.database.template_tenant_connection were ever missing.
            $templateConnectionName = config('tenancy.database.central_connection'); // Or a specific inert placeholder name
            Log::warning('Tenant template connection name not found in tenancy config, falling back.', ['fallback_connection' => $templateConnectionName]);
        }

        $baseConfig = config("database.connections.{$templateConnectionName}");

        if (!$baseConfig) {
            Log::error('Tenant template connection configuration not found in database config.', ['template_name' => $templateConnectionName]);
            // Handle error: throw exception or set a very minimal, safe default $baseConfig
            throw new Exception("Configuration for database connection '{$templateConnectionName}' not found.");
        }

        $tenantConfig = array_merge($baseConfig, [
            'database' => $dbName,
            'username' => $username,
            'password' => $password,
        ]);

        Config::set('database.connections.tenant', $tenantConfig);
        Log::info("Runtime tenant connection 'tenant' configured using base '{$templateConnectionName}' for database '{$dbName}'.");
    }

    protected function createCpanelDatabase(string $dbName): void
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authorization
        ])->post($this->cpanelUrl . '/execute/Mysql/create_database', [
            'name' => $dbName
        ]);

        $this->validateResponse($response, "create database {$dbName}");
        Log::info("Created cPanel database: {$dbName}");
    }

    protected function createCpanelUser(string $username, string $password): void
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authorization
        ])->post($this->cpanelUrl . '/execute/Mysql/create_user', [
            'name' => $username,
            'password' => $password
        ]);

        $this->validateResponse($response, "create user {$username}");
        Log::info("Created cPanel user: {$username}");
    }

    protected function grantPrivileges(string $username, string $dbName): void
    {
        $response = Http::withHeaders([
            'Authorization' => $this->authorization
        ])->post($this->cpanelUrl . '/execute/Mysql/set_privileges_on_database', [
            'user' => $username,
            'database' => $dbName,
            'privileges' => 'ALL'
        ]);

        $this->validateResponse($response, "grant privileges for {$username} on {$dbName}");
        Log::info("Granted privileges for user {$username} on database {$dbName}");
    }

    /**
     * Validate cPanel API response and throw exception if failed
     */
    protected function validateResponse($response, string $operation): void
    {
        if (!$response->successful()) {
            $errorBody = $response->body();
            $statusCode = $response->status();

            Log::error("cPanel API operation failed", [
                'operation' => $operation,
                'status_code' => $statusCode,
                'response_body' => $errorBody
            ]);

            throw new Exception("Failed to {$operation}. Status: {$statusCode}, Response: {$errorBody}");
        }

        // Also check if cPanel returned an error in the response body
        $responseData = $response->json();
        if (isset($responseData['status']) && $responseData['status'] === 0) {
            $errorMessage = $responseData['errors'][0] ?? 'Unknown cPanel error';
            Log::error("cPanel API returned error", [
                'operation' => $operation,
                'error' => $errorMessage,
                'full_response' => $responseData
            ]);
            throw new Exception("cPanel API error for {$operation}: {$errorMessage}");
        }
    }

    protected function getDatabaseName(TenantWithDatabase $tenant): string
    {
        // Check if custom db name is stored in tenant data
        if (isset($tenant->data['db_name'])) {
            return $tenant->data['db_name'];
        }

        // Generate database name using your existing pattern
        // Note: cPanel database names are limited to 64 characters
        $cleanId = str_replace('-', '_', $tenant->id);
        $dbName = $this->dbPrefix . $cleanId . '_db';

        // Truncate if too long (cPanel database name limit is usually 64 chars)
        if (strlen($dbName) > 64) {
            $dbName = $this->dbPrefix . substr($cleanId, 0, 50) . '_db';
        }

        return $dbName;
    }

    protected function getUsername(TenantWithDatabase $tenant): string
    {
        // Check if custom username is stored in tenant data
        if (isset($tenant->data['db_username'])) {
            return $tenant->data['db_username'];
        }

        // Generate username (cPanel usernames are limited to 16 characters typically)
        $cleanId = str_replace('-', '_', substr($tenant->id, 0, 8));
        $username = $this->dbPrefix . $cleanId . '_u';

        // Ensure username doesn't exceed 16 characters
        if (strlen($username) > 16) {
            $username = substr($this->dbPrefix, 0, 7) . substr($cleanId, 0, 5) . '_u';
        }

        return $username;
    }

    protected function getPassword(TenantWithDatabase $tenant): string
    {
        // Check if password is stored in tenant data
        if (isset($tenant->data['db_password'])) {
            return $tenant->data['db_password'];
        }

        // Generate a strong password
        return 'Tenant_' . ucfirst(str_replace('-', '', substr($tenant->id, 0, 8))) . '!23';
    }
}
