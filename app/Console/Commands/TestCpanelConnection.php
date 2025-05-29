<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class TestCpanelConnection extends Command
{
    protected $signature = 'cpanel:test';
    protected $description = 'Test cPanel API connection';

    public function handle()
    {
        $cpanelUrl = config('services.cpanel.url');
        $authorization = config('services.cpanel.authorization');

        $this->info("Testing cPanel connection...");
        $this->info("URL: {$cpanelUrl}");
        $this->info("Auth: " . substr($authorization, 0, 20) . "...");

        try {
            // Test basic API connectivity
            $response = Http::withHeaders([
                'Authorization' => $authorization
            ])->get($cpanelUrl . '/execute/Mysql/list_databases');

            if ($response->successful()) {
                $data = $response->json();
                $this->info("✅ Connection successful!");
                $this->info("Response status: " . $data['status']);

                if (isset($data['data'])) {
                    $this->info("Databases found: " . count($data['data']));
                    $this->line("Database structure:");
                    $this->line(json_encode($data['data'], JSON_PRETTY_PRINT));

                    // Try to display databases safely
                    foreach ($data['data'] as $index => $db) {
                        if (is_array($db)) {
                            $this->line("  Database {$index}: " . json_encode($db));
                        } else {
                            $this->line("  Database {$index}: {$db}");
                        }
                    }
                } else {
                    $this->warning("No 'data' field in response");
                    $this->line("Full response: " . json_encode($data, JSON_PRETTY_PRINT));
                }
            } else {
                $this->error("❌ Connection failed!");
                $this->error("Status: " . $response->status());
                $this->error("Response: " . $response->body());
            }

        } catch (\Exception $e) {
            $this->error("❌ Exception occurred: " . $e->getMessage());
        }

        return 0;
    }
}