<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name')->unique();
            $table->string('tax_number')->unique();
            $table->string('website')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable(); // For extensibility
            $table->timestamps();
            $table->softDeletes();
        });

        // Add index for faster retrieval
        Schema::table('companies', function (Blueprint $table) {
            $table->index('legal_name');
            $table->index('tax_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
