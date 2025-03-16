<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('color', 10);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default order statuses
        DB::table('order_statuses')->insert([
            ['name_en' => 'New', 'name_ar' => 'جديد', 'color' => '#3498db', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Processing', 'name_ar' => 'قيد المعالجة', 'color' => '#f39c12', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Shipped', 'name_ar' => 'تم الشحن', 'color' => '#9b59b6', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Delivered', 'name_ar' => 'تم التسليم', 'color' => '#2ecc71', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Cancelled', 'name_ar' => 'ملغي', 'color' => '#e74c3c', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_statuses');
    }
};
