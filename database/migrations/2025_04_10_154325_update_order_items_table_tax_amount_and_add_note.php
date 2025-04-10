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
            // Change tax_amount from bigint to decimal to handle decimal values properly
            $table->decimal('tax_amount', 20, 2)->nullable()->change();

            // Add a new nullable note column
            $table->text('note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Revert tax_amount back to bigint
            $table->unsignedBigInteger('tax_amount')->change();

            // Drop the note column
            $table->dropColumn('note');
        });
    }
};
