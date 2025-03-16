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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('code')->unique();
            $table->string('icon')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        // Add index for faster retrieval
        Schema::table('payment_methods', function (Blueprint $table) {
            $table->index('code');
        });

        // Insert default payment methods
        DB::table('payment_methods')->insert([
            ['name_en' => 'Credit Card', 'name_ar' => 'بطاقة ائتمان', 'code' => 'credit_card', 'icon' => 'credit-card', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'PayPal', 'name_ar' => 'باي بال', 'code' => 'paypal', 'icon' => 'paypal', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Bank Transfer', 'name_ar' => 'تحويل بنكي', 'code' => 'bank_transfer', 'icon' => 'bank', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name_en' => 'Cash on Delivery', 'name_ar' => 'الدفع عند الاستلام', 'code' => 'cod', 'icon' => 'money', 'is_active' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
