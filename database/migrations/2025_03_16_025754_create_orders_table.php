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
            // Primary key
            $table->id();

            // Foreign keys: Organizational context
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('point_of_sale_id')->nullable()->constrained('point_of_sales')->onDelete('set null');

            // Foreign keys: Users and relations
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('order_status_id')->nullable()->constrained()->nullOnDelete();

            // Order identification
            $table->string('number');

            // Customer details (denormalized for performance/history)
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone_number')->nullable();

            // Foreign keys: Payment
            $table->foreignId('payment_method_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();

            // Foreign keys: Addresses
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();

            // Financial fields
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('discount_type')->default('fixed');
            $table->decimal('discount_totals', 15, 2)->default(0);
            $table->decimal('subtotal_after_discount', 15, 2)->default(0);
            $table->decimal('shipping_fee', 10, 2)->nullable();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('other_taxes', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable()->default(0);

            // Dates and timestamps
            $table->date('issue_date')->nullable();
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();

            // Status and meta
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable();

            // Laravel timestamps and soft deletes
            $table->timestamps();
            $table->softDeletes();
        });


        // Add indexes for high-read queries
        Schema::table('orders', function (Blueprint $table) {
            $table->index(['company_id', 'is_active']);
            $table->index(['point_of_sale_id', 'is_active']);
            $table->unique(['company_id', 'number']);
            $table->unique(['point_of_sale_id', 'number']);

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
