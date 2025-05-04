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
        Schema::table('invoices', function (Blueprint $table) {
            // Add new columns
            $table->decimal('amount_paid', 10, 2)->nullable()->default(0);
            $table->foreignId('point_of_sale_id')->nullable()->constrained()->nullOnDelete();
            $table->decimal('vat', 10, 2)->nullable();
            $table->decimal('other_taxes', 10, 2)->nullable();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_phone')->nullable()->change();
            $table->dropColumn('tax_amount');

            // Rename columns
            $table->renameColumn('discount_amount', 'discount');
            $table->renameColumn('total_amount', 'total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['amount_paid', 'vat', 'other_taxes']);
            $table->string('customer_phone')->nullable(false)->change();
            $table->unsignedBigInteger('tax_amount');

            // Revert column renames
            $table->renameColumn('discount', 'discount_amount');
            $table->renameColumn('total', 'total_amount');
        });
    }
};
