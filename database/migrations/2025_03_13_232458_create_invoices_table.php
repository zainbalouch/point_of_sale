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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            
            // Polymorphic relationship - allows any entity to be invoiceable
            $table->morphs('invoiceable');
            
            // Customer information
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            
            // We'll use the Address model via polymorphic relationship instead of inline address
            // References to specific addresses for billing and shipping
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses');
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses');
            
            // Amounts (stored as big integers)
            $table->bigInteger('subtotal')->default(0);
            $table->bigInteger('tax_amount')->default(0);
            $table->bigInteger('discount_amount')->default(0);
            $table->bigInteger('total_amount')->default(0);
            
            // Dates with time (using datetime instead of date)
            $table->datetime('issue_datetime');
            $table->datetime('due_datetime');
            $table->datetime('paid_datetime')->nullable();
            
            // Foreign keys
            $table->foreignId('invoice_status_id')->constrained('invoice_statuses');
            $table->foreignId('currency_id')->constrained('currencies');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
