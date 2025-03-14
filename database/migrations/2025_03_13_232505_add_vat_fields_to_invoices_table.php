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
            // Add customer reference - simplest approach
            $table->foreignId('customer_id')->nullable()
                ->constrained('users')->nullOnDelete()->comment('Reference to the customer');
            
            // Add location information for tax purposes
            $table->foreignId('country_id')->nullable()->after('currency_id')
                ->constrained('countries')->nullOnDelete()->comment('Billing country');
            $table->foreignId('state_id')->nullable()->after('country_id')
                ->constrained('states')->nullOnDelete()->comment('Billing state/province');
            
            // Indexes for efficient querying
            $table->index('customer_id');
            $table->index(['country_id', 'state_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['customer_id']);
            $table->dropIndex(['country_id', 'state_id']);
            
            // Remove foreign keys
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['country_id']);
            $table->dropForeign(['state_id']);
            
            // Remove columns
            $table->dropColumn([
                'customer_id',
                'country_id',
                'state_id',
            ]);
        });
    }
}; 