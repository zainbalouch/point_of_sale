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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->string('code')->nullable();
            $table->unsignedBigInteger('price'); // Stored as money
            $table->unsignedBigInteger('sale_price')->nullable(); // Stored as money
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('point_of_sale_id')->nullable()->constrained()->nullOnDelete();
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add indexes for high-read queries
        Schema::table('products', function (Blueprint $table) {
            $table->index('sku');
            $table->index('code');
            $table->index('slug');
            $table->index(['point_of_sale_id', 'is_active']);
            $table->index('product_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
