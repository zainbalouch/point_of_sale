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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('address_type_id')->nullable()->constrained()->nullOnDelete();
            $table->morphs('addressable');
            $table->string('street');
            $table->string('postal_code')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->string('contact_person_full_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
