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
        Schema::table('invoice_template_settings', function (Blueprint $table) {
            $table->string('field_type')->default('text')->after('key_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_template_settings', function (Blueprint $table) {
            $table->dropColumn('field_type');
        });
    }
};
