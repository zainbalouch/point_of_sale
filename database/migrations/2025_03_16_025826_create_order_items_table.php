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
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('unit_price');
            $table->foreignId('tax_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('tax_amount');
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->decimal('total_price', 20, 2);
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
