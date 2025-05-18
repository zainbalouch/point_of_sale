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
            // Primary key
            $table->id();

            // Core relationships
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            // Product information
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();

            // Pricing and quantity
            $table->unsignedInteger('quantity')->nullable();
            $table->unsignedBigInteger('unit_price')->nullable();
            $table->unsignedBigInteger('subtotal')->nullable();
            $table->unsignedBigInteger('discount_amount')->default(0);

            // Taxation
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->decimal('vat_amount', 10, 2)->nullable();
            $table->decimal('other_taxes_amount', 10, 2)->nullable();

            // Totals
            $table->unsignedBigInteger('total')->nullable();
            $table->decimal('total_price', 10, 2)->nullable();

            // Notes
            $table->text('note')->nullable();

            // Laravel timestamps
            $table->timestamps();
            $table->softDeletes();
        });


        // Add indexes for high-read queries
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->index('invoice_id');
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
