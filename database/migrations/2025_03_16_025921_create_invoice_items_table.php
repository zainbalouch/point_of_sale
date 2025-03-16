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
            $table->morphs('invoiceable');
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('unit_price');
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('total');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add indexes for high-read queries
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->index('invoice_id');
            $table->index('invoiceable_id');
            $table->index('invoiceable_type');
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
