<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('symbol');
            $table->timestamps();
            $table->softDeletes();
        });

        // Add index for faster retrieval
        Schema::table('currencies', function (Blueprint $table) {
            $table->index('code');
        });

        // Insert common currencies
        DB::table('currencies')->insert([
            ['name' => 'Saudi Riyal', 'code' => 'SAR', 'symbol' => 'ر.س', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'British Pound', 'code' => 'GBP', 'symbol' => '£', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
