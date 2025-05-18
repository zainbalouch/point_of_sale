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
        Schema::create('address_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name_en');
            $table->string('name_ar');
            $table->timestamps();
        });

        // Add index for faster retrieval
        Schema::table('address_types', function (Blueprint $table) {
            $table->index('company_id');
        });

        // Insert default address types
        DB::table('address_types')->insert([
            ['id' => 1, 'name_en' => 'Shipping', 'name_ar' => 'شحن', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name_en' => 'Billing', 'name_ar' => 'فواتير', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address_types');
    }
};
