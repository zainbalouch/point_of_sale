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
        Schema::create('tax_rates', function (Blueprint $table) {
            $table->id();
            
            // Which company/organization owns this tax rate
            $table->foreignId('company_id')->constrained('companies')->comment('References the company that owns this tax rate');
            
            // Tax rate details
            $table->string('name');
            $table->integer('rate')->comment('Stored as basis points (1/100th of a percent), e.g., 825 = 8.25%');
            
            // VAT-specific fields
            $table->string('vat_type')->nullable()->comment('Type of VAT (standard, reduced, etc.)');
            $table->boolean('requires_vat_number')->default(false)->comment('Whether the buyer needs a VAT number for this rate');
            
            // Tax rate application settings
            $table->boolean('is_default')->default(false)->comment('Whether this is the default tax rate for the company');
            $table->boolean('is_active')->default(true);
            
            // Valid date range (for tax rates that change over time)
            $table->date('effective_from')->nullable();
            $table->date('effective_until')->nullable();
            
            // Audit fields
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes for efficient querying
            $table->index(['company_id', 'is_default']);
            $table->index(['company_id', 'is_active']);
            $table->index(['is_active', 'effective_from', 'effective_until']);
            $table->index(['vat_type', 'requires_vat_number']);
            
            // Ensure uniqueness of default tax rate per company
            $table->unique(['company_id', 'is_default', 'is_active'], 'unique_active_default_tax_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rates');
    }
}; 