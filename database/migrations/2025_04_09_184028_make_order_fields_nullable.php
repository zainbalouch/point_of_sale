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
        // Make order fields nullable
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->change();
            $table->string('customer_email')->nullable()->change();
            $table->string('customer_phone_number')->nullable()->change();
            $table->unsignedBigInteger('shipping_fee')->nullable()->change();
            $table->unsignedBigInteger('subtotal')->nullable()->change();
            $table->unsignedBigInteger('tax')->nullable()->change();
            $table->unsignedBigInteger('total')->nullable()->change();
        });

        // Make order items fields nullable where they appear as optional in the form
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->nullable()->change();
            $table->unsignedBigInteger('unit_price')->nullable()->change();
            $table->unsignedBigInteger('tax_amount')->nullable()->change();
            $table->unsignedBigInteger('total_price')->nullable()->change();
        });

        // Make address fields nullable and add missing fields
        Schema::table('addresses', function (Blueprint $table) {
            // Make the addressable polymorphic relationship nullable
            $table->unsignedBigInteger('addressable_id')->nullable()->change();
            $table->string('addressable_type')->nullable()->change();

            // Make the street field nullable
            $table->string('street')->nullable()->change();

            // Add city, state, country fields that are in the form
            $table->string('city')->nullable()->after('street');
            $table->string('state')->nullable()->after('city');
            $table->string('country')->nullable()->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert order fields
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_name')->nullable(false)->change();
            $table->string('customer_email')->nullable(false)->change();
            $table->string('customer_phone_number')->nullable(false)->change();
            $table->unsignedBigInteger('shipping_fee')->nullable(false)->change();
            $table->unsignedBigInteger('subtotal')->nullable(false)->change();
            $table->unsignedBigInteger('tax')->nullable(false)->change();
            $table->unsignedBigInteger('total')->nullable(false)->change();
        });

        // Revert order items fields
        Schema::table('order_items', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->nullable(false)->change();
            $table->unsignedBigInteger('unit_price')->nullable(false)->change();
            $table->unsignedBigInteger('tax_amount')->nullable(false)->change();
            $table->unsignedBigInteger('total_price')->nullable(false)->change();
        });

        // Revert address fields
        Schema::table('addresses', function (Blueprint $table) {
            // Make the addressable polymorphic relationship not nullable
            $table->unsignedBigInteger('addressable_id')->nullable(false)->change();
            $table->string('addressable_type')->nullable(false)->change();

            // Make street not nullable
            $table->string('street')->nullable(false)->change();

            // Drop added columns
            $table->dropColumn(['city', 'state', 'country']);
        });
    }
};
