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
        Schema::create('invoice_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('color', 10);
            $table->timestamps();
        });

        // Insert default invoice statuses
        DB::table('invoice_statuses')->insert([
            ['name_en' => 'Draft', 'name_ar' => 'مسودة', 'color' => '#95a5a6', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Sent', 'name_ar' => 'مرسلة', 'color' => '#3498db', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Paid', 'name_ar' => 'مدفوعة', 'color' => '#2ecc71', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Overdue', 'name_ar' => 'متأخرة', 'color' => '#e74c3c', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Cancelled', 'name_ar' => 'ملغاة', 'color' => '#7f8c8d', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Partially Paid', 'name_ar' => 'مدفوعة جزئيا', 'color' => '#f39c12', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_statuses');
    }
};
