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
        Schema::create('order_items', function (Blueprint $table) {
            // Primary key
            $table->id();

            // Foreign keys
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();

            // Product identifiers and descriptions
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();

            // Quantities and pricing
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->string('discount_type')->default('fixed');
            $table->decimal('vat_amount', 10, 2)->nullable();
            $table->decimal('other_taxes_amount', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2);

            // Misc
            $table->text('note')->nullable();

            // Laravel timestamps
            $table->timestamps();
            $table->softDeletes();
        });


        // Add indexes for high-read queries
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
