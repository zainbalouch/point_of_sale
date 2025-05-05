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
            $table->string('discount_type')->default('fixed')->after('discount');
            $table->decimal('discount_totals', 15, 2)->default(0)->after('other_taxes');
            $table->decimal('subtotal_after_discount', 15, 2)->default(0)->after('subtotal');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('discount_type');
            $table->dropColumn('discount_totals');
            $table->dropColumn('subtotal_after_discount');
        });
    }
};
