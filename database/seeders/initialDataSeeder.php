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

        // Seed companies first (as it's referenced by other tables)
        $this->seedCompanies();

        // Seed point of sales
        $this->seedPointOfSales();

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

        // Seed invoice template settings
        $this->seedInvoiceTemplateSettings();

        $this->command->info('All initial data has been seeded successfully.');
    }

    /**
     * Seed the companies table.
     */
    private function seedCompanies()
    {
        $this->command->info('Seeding companies...');

        $companies = [
            [
                'id' => 1,
                'legal_name' => 'Noha',
                'tax_number' => '123456789123456',
                'website' => null,
                'email' => 'noha@gmail.com',
                'phone_number' => '0574514152',
                'logo' => null,
                'is_active' => 1,
                'meta' => null,
                'created_at' => '2025-05-11 05:53:41',
                'updated_at' => '2025-05-17 05:56:38',
                'deleted_at' => null,
                'address' => 'Umm Tulaih, Al Jaradiyah, Al Madinah Munawrah Road, Riyadh'
            ]
        ];

        foreach ($companies as $company) {
            DB::table('companies')->updateOrInsert(
                ['id' => $company['id']],
                $company
            );
        }
    }

    /**
     * Seed the point_of_sales table.
     */
    private function seedPointOfSales()
    {
        $this->command->info('Seeding point of sales...');

        $pointOfSales = [
            [
                'id' => 1,
                'name_en' => 'Noha',
                'name_ar' => 'أسلوب',
                'description_en' => null,
                'description_ar' => null,
                'company_id' => 1,
                'is_active' => 1,
                'meta' => '[]',
                'created_at' => '2025-05-11 05:55:49',
                'updated_at' => '2025-05-17 05:57:45',
                'deleted_at' => null,
                'address' => 'Johar Town Riyadh'
            ]
        ];

        foreach ($pointOfSales as $pos) {
            DB::table('point_of_sales')->updateOrInsert(
                ['id' => $pos['id']],
                $pos
            );
        }
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

    /**
     * Seed the invoice_template_settings table.
     */
    private function seedInvoiceTemplateSettings()
    {
        $this->command->info('Seeding invoice template settings...');

        $invoiceTemplateSettings = [
            [
                'id' => 2,
                'key_name' => 'note',
                'field_type' => 'rich_text_editor',
                'company_id' => 1,
                'value_en' => '<p><strong>SNAP:</strong> NOHAALNAMLAH<br> <strong>INSTAGRAM:</strong> NOHAALNAMLAH&nbsp;</p><p><strong>Bank Details:</strong><br> <strong>Account Holder:</strong> Noha Alnamlah<br> <strong>Bank Name:</strong> Al Rajhi Bank<br> <strong>Account Number:</strong> SA9080000462608010203090&nbsp;</p>',
                'value_ar' => '<p dir="rtl">&nbsp;<strong>سناب:</strong> NOHAALNAMLAH<br> <strong>إنستجرام:</strong> NOHAALNAMLAH&nbsp;</p><p dir="rtl"><strong>تفاصيل الحساب البنكي:</strong><br> <strong>اسم صاحب الحساب:</strong> نهى النملة<br> <strong>اسم البنك:</strong> بنك الراجحي<br> <strong>رقم الحساب:</strong> SA9080000462608010203090&nbsp;</p>',
                'created_at' => '2025-05-11 08:33:27',
                'updated_at' => '2025-05-17 07:29:07'
            ],
            [
                'id' => 3,
                'key_name' => 'logo',
                'field_type' => 'image',
                'company_id' => 1,
                'value_en' => 'settings/01JVEK010YFD6JK6JGFX0TRN17.jpeg',
                'value_ar' => 'settings/01JVEK0112P8YVDQKD1F74ABWD.jpeg',
                'created_at' => '2025-05-17 07:40:33',
                'updated_at' => '2025-05-17 07:40:33'
            ],
            [
                'id' => 4,
                'key_name' => 'show_customer_address',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:33:54',
                'updated_at' => '2025-05-17 08:32:43'
            ],
            [
                'id' => 5,
                'key_name' => 'show_customer_phone_number',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:34:06',
                'updated_at' => '2025-05-17 08:32:49'
            ],
            [
                'id' => 6,
                'key_name' => 'show_customer_vat',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:34:52',
                'updated_at' => '2025-05-17 08:32:53'
            ],
            [
                'id' => 7,
                'key_name' => 'show_company_vat',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:11',
                'updated_at' => '2025-05-17 08:32:56'
            ],
            [
                'id' => 8,
                'key_name' => 'show_company_email',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:25',
                'updated_at' => '2025-05-17 08:33:00'
            ],
            [
                'id' => 9,
                'key_name' => 'show_company_address',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:51',
                'updated_at' => '2025-05-17 08:33:18'
            ],
            [
                'id' => 10,
                'key_name' => 'invoice_title',
                'field_type' => 'text',
                'company_id' => 1,
                'value_en' => 'VAT Invoice',
                'value_ar' => 'فاتورة مبيعات ضريبية',
                'created_at' => '2025-05-17 07:38:11',
                'updated_at' => '2025-05-17 08:48:54'
            ],
            [
                'id' => 11,
                'key_name' => 'order_invoice_title',
                'field_type' => 'text',
                'company_id' => 1,
                'value_en' => 'Quotation',
                'value_ar' => 'عرض سعر',
                'created_at' => '2025-05-17 07:39:25',
                'updated_at' => '2025-05-17 08:47:21'
            ],
            [
                'id' => 12,
                'key_name' => 'show_customer_email',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:33:09',
                'updated_at' => '2025-05-17 08:32:39'
            ],
            [
                'id' => 13,
                'key_name' => 'show_company_phone_number',
                'field_type' => 'checkbox',
                'company_id' => 1,
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 10:17:32',
                'updated_at' => '2025-05-17 10:17:32'
            ]
        ];

        foreach ($invoiceTemplateSettings as $setting) {
            DB::table('invoice_template_settings')->updateOrInsert(
                ['id' => $setting['id']],
                $setting
            );
        }
    }
}
