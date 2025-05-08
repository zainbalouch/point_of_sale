<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class initialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Starting to seed initial necessary data...');

        // Seed address_types table
        $this->seedAddressTypes();

        // Seed currencies table
        $this->seedCurrencies();

        // Seed payment_methods table
        $this->seedPaymentMethods();

        // Seed payment_statuses table
        $this->seedPaymentStatuses();

        // Seed order_statuses table
        $this->seedOrderStatuses();

        // Seed settings table
        $this->seedSettings();

        $this->command->info('All initial data has been seeded successfully.');
    }

    /**
     * Seed the address_types table.
     */
    private function seedAddressTypes()
    {
        $this->command->info('Seeding address types...');

        $addressTypes = [
            [
                'id' => 1,
                'name_en' => 'Shipping',
                'name_ar' => 'شحن',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16'
            ],
            [
                'id' => 2,
                'name_en' => 'Billing',
                'name_ar' => 'فواتير',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16'
            ]
        ];

        foreach ($addressTypes as $addressType) {
            DB::table('address_types')->updateOrInsert(
                ['id' => $addressType['id']],
                $addressType
            );
        }
    }

    /**
     * Seed the currencies table.
     */
    private function seedCurrencies()
    {
        $this->command->info('Seeding currencies...');

        $currencies = [
            [
                'id' => 1,
                'name' => 'Saudi Riyal',
                'code' => 'SAR',
                'symbol' => 'ر.س',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'name' => 'Pakistani Rupees',
                'code' => 'PKR',
                'symbol' => 'Rs',
                'created_at' => '2025-05-04 08:38:26',
                'updated_at' => '2025-05-04 08:38:26',
                'deleted_at' => null
            ]
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->updateOrInsert(
                ['id' => $currency['id']],
                $currency
            );
        }
    }

    /**
     * Seed the payment_methods table.
     */
    private function seedPaymentMethods()
    {
        $this->command->info('Seeding payment methods...');

        $paymentMethods = [
            [
                'id' => 1,
                'name_en' => 'Credit Card',
                'name_ar' => 'بطاقة ائتمان',
                'code' => 'credit_card',
                'icon' => 'credit-card',
                'is_active' => 1,
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name_en' => 'PayPal',
                'name_ar' => 'باي بال',
                'code' => 'paypal',
                'icon' => 'paypal',
                'is_active' => 1,
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'name_en' => 'Bank Transfer',
                'name_ar' => 'تحويل بنكي',
                'code' => 'bank_transfer',
                'icon' => 'bank',
                'is_active' => 1,
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'name_en' => 'Cash on Delivery',
                'name_ar' => 'الدفع عند الاستلام',
                'code' => 'cod',
                'icon' => 'money',
                'is_active' => 1,
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ]
        ];

        foreach ($paymentMethods as $method) {
            DB::table('payment_methods')->updateOrInsert(
                ['id' => $method['id']],
                $method
            );
        }
    }

    /**
     * Seed the payment_statuses table.
     */
    private function seedPaymentStatuses()
    {
        $this->command->info('Seeding payment statuses...');

        $paymentStatuses = [
            [
                'id' => 1,
                'name_en' => 'Pending',
                'name_ar' => 'قيد الانتظار',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name_en' => 'Completed',
                'name_ar' => 'مكتمل',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'name_en' => 'Failed',
                'name_ar' => 'فشل',
                'color' => '#e74c3c',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'name_en' => 'Refunded',
                'name_ar' => 'مسترجع',
                'color' => '#3498db',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ]
        ];

        foreach ($paymentStatuses as $status) {
            DB::table('payment_statuses')->updateOrInsert(
                ['id' => $status['id']],
                $status
            );
        }
    }

    /**
     * Seed the order_statuses table.
     */
    private function seedOrderStatuses()
    {
        $this->command->info('Seeding order statuses...');

        $orderStatuses = [
            [
                'id' => 1,
                'name_en' => 'New',
                'name_ar' => 'جديد',
                'color' => '#3498db',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'name_en' => 'Processing',
                'name_ar' => 'قيد المعالجة',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'name_en' => 'Shipped',
                'name_ar' => 'تم الشحن',
                'color' => '#9b59b6',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'name_en' => 'Delivered',
                'name_ar' => 'تم التسليم',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'name_en' => 'Cancelled',
                'name_ar' => 'ملغي',
                'color' => '#e74c3c',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ]
        ];

        foreach ($orderStatuses as $status) {
            DB::table('order_statuses')->updateOrInsert(
                ['id' => $status['id']],
                $status
            );
        }
    }

    /**
     * Seed the settings table.
     */
    private function seedSettings()
    {
        $this->command->info('Seeding settings...');

        $settings = [
            [
                'id' => 1,
                'key' => 'default_currency',
                'value' => 'SAR',
                'field_type' => 'currency',
                'created_at' => '2025-05-04 08:45:11',
                'updated_at' => '2025-05-04 08:45:11'
            ],
            [
                'id' => 2,
                'key' => 'default_payment_methode',
                'value' => 'Cash on Delivery',
                'field_type' => 'payment_method',
                'created_at' => '2025-05-04 09:44:22',
                'updated_at' => '2025-05-04 09:46:18'
            ],
            [
                'id' => 3,
                'key' => 'logo_light',
                'value' => 'settings/01JTE0XS8WDHCJY07NB1CZJY3K.jpg',
                'field_type' => 'image',
                'created_at' => '2025-05-04 15:13:21',
                'updated_at' => '2025-05-04 16:09:04'
            ],
            [
                'id' => 4,
                'key' => 'logo_dark',
                'value' => 'settings/01JTE0Z5VEXTVPBXPHKF1H2FQ5.jpg',
                'field_type' => 'image',
                'created_at' => '2025-05-04 15:13:46',
                'updated_at' => '2025-05-04 16:09:49'
            ]
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['id' => $setting['id']],
                $setting
            );
        }
    }

}
