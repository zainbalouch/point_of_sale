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
        Schema::table('order_items', function (Blueprint $table) {
            // Add new vat_amount column
            $table->decimal('vat_amount', 10, 2)->nullable();

            // Rename tax_amount to other_taxes_amount
            if (Schema::hasColumn('order_items', 'tax_amount')) {
                $table->renameColumn('tax_amount', 'other_taxes_amount');
                // Make sure the renamed column is nullable
                $table->decimal('other_taxes_amount', 10, 2)->nullable()->change();
            } else {
                // If tax_amount doesn't exist, create other_taxes_amount
                $table->decimal('other_taxes_amount', 10, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Remove new column
            $table->dropColumn('vat_amount');

            // Reverse rename operation
            if (Schema::hasColumn('order_items', 'other_taxes_amount')) {
                $table->renameColumn('other_taxes_amount', 'tax_amount');
                // Make sure it goes back to its original state
                $table->decimal('tax_amount', 10, 2)->nullable(false)->change();
            }
        });
    }
};
