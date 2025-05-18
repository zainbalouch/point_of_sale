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
            // Primary key
            $table->id();

            // Identifiers
            $table->string('number');

            // Foreign keys: Core relations
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('point_of_sale_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('issued_by_user')->nullable()->constrained('users')->nullOnDelete();

            // Denormalized customer data
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();

            // Financial data
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('discount')->default(0);
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('other_taxes', 10, 2)->nullable();
            $table->unsignedBigInteger('total');
            $table->decimal('amount_paid', 10, 2)->nullable()->default(0);

            // Dates
            $table->dateTime('issue_date');
            $table->dateTime('due_date')->nullable();
            $table->dateTime('paid_date')->nullable();

            // Foreign keys: Meta relations
            $table->foreignId('invoice_status_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('currency_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('billing_address_id')->nullable()->constrained('addresses')->nullOnDelete();
            $table->foreignId('shipping_address_id')->nullable()->constrained('addresses')->nullOnDelete();

            // Meta and timestamps
            $table->json('meta')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });


        // Add indexes for high-read queries
        Schema::table('invoices', function (Blueprint $table) {
            $table->index('number');
            $table->index(['company_id', 'number']);
            $table->index(['customer_id', 'created_at']);
            $table->index('invoice_status_id');
            $table->unique(['company_id', 'number']);
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
