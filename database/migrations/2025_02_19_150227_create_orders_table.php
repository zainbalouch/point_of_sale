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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            
            // Polymorphic relationship - allows any entity to be orderable
            $table->nullableMorphs('orderable');
            
            // Customer information
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone_number');
            
            // Addresses are handled via morphMany relationship using the Addressable trait
            
            // Order details
            $table->foreignId('order_status_id')->constrained('order_statuses');
            $table->bigInteger('shipping_fee')->default(0);
            $table->bigInteger('subtotal');
            $table->bigInteger('tax');
            $table->bigInteger('total');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
            $table->foreignId('currency_id')->constrained('currencies');
            
            // Timestamps for order process
            $table->dateTime('estimated_delivery_at')->nullable();
            $table->dateTime('delivered_at')->nullable();
            $table->dateTime('shipped_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
