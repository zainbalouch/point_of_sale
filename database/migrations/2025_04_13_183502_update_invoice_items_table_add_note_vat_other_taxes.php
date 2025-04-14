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
        Schema::table('invoice_items', function (Blueprint $table) {
            // Add new columns
            $table->text('note')->nullable();
            $table->decimal('vat_amount', 10, 2)->nullable();
            $table->decimal('other_taxes_amount', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();

            // Remove columns
            $table->dropColumn(['tax_amount', 'invoiceable_type', 'invoiceable_id', 'subtotal', 'total']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_items', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['note', 'vat_amount', 'other_taxes_amount', 'total_price']);

            // Add back removed columns
            $table->unsignedBigInteger('tax_amount');
            $table->morphs('invoiceable');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
        });
    }
};
