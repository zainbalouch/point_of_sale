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
        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('color', 10);
            $table->timestamps();
            $table->softDeletes();
        });

        // Insert default transaction statuses
        DB::table('transaction_statuses')->insert([
            ['name_en' => 'Pending', 'name_ar' => 'قيد الانتظار', 'color' => '#f39c12', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Completed', 'name_ar' => 'مكتمل', 'color' => '#2ecc71', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Failed', 'name_ar' => 'فشل', 'color' => '#e74c3c', 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Refunded', 'name_ar' => 'مسترجع', 'color' => '#3498db', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_statuses');
    }
};
