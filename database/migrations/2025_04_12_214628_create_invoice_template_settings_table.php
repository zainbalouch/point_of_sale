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
        Schema::create('invoice_template_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key_name');
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->text('value_en')->nullable();
            $table->text('value_ar')->nullable();
            $table->timestamps();

            // Creating a unique index on key_name and company_id
            $table->unique(['key_name', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_template_settings');
    }
};
