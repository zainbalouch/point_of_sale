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
        Schema::table('orders', function (Blueprint $table) {
            // Add new vat column
            $table->decimal('vat', 10, 2)->nullable();

            // Add new discount column
            $table->decimal('discount', 10, 2)->nullable();

            // Add new amount_paid column
            $table->decimal('amount_paid', 10, 2)->nullable()->default(0);

            // Rename tax to other_taxes
            if (Schema::hasColumn('orders', 'tax')) {
                $table->renameColumn('tax', 'other_taxes');
                // Make sure the renamed column is nullable
                $table->decimal('other_taxes', 10, 2)->nullable()->change();
            } else {
                // If tax doesn't exist, create other_taxes
                $table->decimal('other_taxes', 10, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['vat', 'discount', 'amount_paid']);

            // Reverse rename operation
            if (Schema::hasColumn('orders', 'other_taxes')) {
                $table->renameColumn('other_taxes', 'tax');
                // Make sure it goes back to its original state
                $table->decimal('tax', 10, 2)->nullable(false)->change();
            }
        });
    }
};
