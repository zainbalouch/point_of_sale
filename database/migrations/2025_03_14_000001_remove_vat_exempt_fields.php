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
        // Remove fields from invoice_items
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->dropColumn([
                'is_vat_exempt',
                'vat_exemption_reason',
            ]);
        });
        
        // Remove fields from order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn([
                'is_vat_exempt',
                'vat_exemption_reason',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add fields back to invoice_items
        Schema::table('invoice_items', function (Blueprint $table) {
            $table->boolean('is_vat_exempt')->default(false)->after('tax_rate_name_snapshot')
                ->comment('Whether this item is exempt from VAT');
            $table->string('vat_exemption_reason')->nullable()->after('is_vat_exempt')
                ->comment('Reason for VAT exemption');
        });
        
        // Add fields back to order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->boolean('is_vat_exempt')->default(false)->after('tax_rate_name_snapshot')
                ->comment('Whether this item is exempt from VAT');
            $table->string('vat_exemption_reason')->nullable()->after('is_vat_exempt')
                ->comment('Reason for VAT exemption');
        });
    }
}; 