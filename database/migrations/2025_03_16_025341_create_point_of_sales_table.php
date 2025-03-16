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
        Schema::create('point_of_sales', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->text('description_en')->nullable();
            $table->text('description_ar')->nullable();
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->json('meta')->nullable(); // For extensibility
            $table->timestamps();
            $table->softDeletes();
        });

        // Add index for faster retrieval
        Schema::table('point_of_sales', function (Blueprint $table) {
            $table->index(['company_id', 'is_active']);
        });

        // Create the pivot table for point_of_sale and user
        Schema::create('point_of_sale_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('point_of_sale_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'point_of_sale_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_of_sale_user');
        Schema::dropIfExists('point_of_sales');
    }
};
