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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            
            // Direct reference fields
            $table->morphs('invoiceable_item');
            
            // Product snapshot data
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();
            
            // Quantities and amounts
            $table->integer('quantity');
            $table->bigInteger('unit_price');
            
            // Tax information - reference plus snapshot value
            $table->foreignId('tax_rate_id')->nullable()->constrained('tax_rates')->nullOnDelete()->comment('Reference to the tax rate used');
            $table->integer('tax_rate_snapshot')->default(0)->comment('Snapshot of the tax rate in basis points at time of invoicing'); 
            $table->string('tax_rate_name_snapshot')->nullable()->comment('Snapshot of the tax rate name at time of invoicing');
            $table->boolean('is_vat_exempt')->default(false)->comment('Whether this item is exempt from VAT');
            $table->string('vat_exemption_reason')->nullable()->comment('Reason for VAT exemption');
            $table->bigInteger('tax_amount')->default(0);
            
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('subtotal');
            $table->bigInteger('total');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
