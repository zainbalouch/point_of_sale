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
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->text('product_description_en')->nullable();
            $table->text('product_description_ar')->nullable();
            $table->string('product_sku');
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete();
            $table->integer('quantity');
            $table->bigInteger('unit_price');
            $table->bigInteger('total_price');
            $table->timestamps();
            $table->softDeletes();
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
