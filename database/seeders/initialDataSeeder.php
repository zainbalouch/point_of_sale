<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class initialDataSeeder extends Seeder
{
    public static $companyNameOverride = null;
    public static $taxNumberOverride = null;
    public static $emailOverride = null;
    public static $passwordOverride = null;
    public static $phoneOverride = null;
    public static $addressOverride = null;

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

        // Seed order_statuses table
        $this->seedTaxes();

        // Seed settings table
        $this->seedSettings();

        // Seed invoice template settings
        $this->seedInvoiceTemplateSettings();

        // Seed roles and permissions
        $this->seedRolesAndPermissions();

        // Seed users
        $this->seedUsers();

        $this->command->info('All initial data has been seeded successfully.');
    }

    /**
     * Seed the companies table.
     */
    private function seedCompanies()
    {
        $this->command->info('Seeding companies...');

        $companyLegalName = self::$companyNameOverride ?: 'Start With Us';
        $taxNumber = self::$taxNumberOverride ?: '123456789123456';
        $email = self::$emailOverride ?: 'noha@gmail.com';
        $phone = self::$phoneOverride ?: '0574514152';
        $address = self::$addressOverride ?: 'Umm Tulaih, Al Jaradiyah, Al Madinah Munawrah Road, Riyadh';

        $companies = [
            [
                'id' => 1,
                'legal_name' => $companyLegalName,
                'tax_number' => $taxNumber,
                'website' => null,
                'email' => $email,
                'phone_number' => $phone,
                'logo' => null,
                'is_active' => 1,
                'meta' => null,
                'created_at' => '2025-05-11 05:53:41',
                'updated_at' => '2025-05-17 05:56:38',
                'deleted_at' => null,
                'address' => $address
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

        $posNameEn = self::$companyNameOverride ?: 'Start With Us';
        $posAddress = self::$addressOverride ?: 'Johar Town Riyadh'; // Assuming POS address can also be overridden by the general address override

        $pointOfSales = [
            [
                'id' => 1,
                'name_en' => $posNameEn,
                'name_ar' => $posNameEn,
                'description_en' => null,
                'description_ar' => null,
                'company_id' => 1,
                'is_active' => 1,
                'meta' => '[]',
                'created_at' => '2025-05-11 05:55:49',
                'updated_at' => '2025-05-17 05:57:45',
                'deleted_at' => null,
                'address' => $posAddress
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
                'company_id' => 1,
                'name_en' => 'Shipping',
                'name_ar' => 'شحن',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16'
            ],
            [
                'id' => 2,
                'company_id' => 1,
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
                'company_id' => 1,
                'name' => 'Saudi Riyal',
                'code' => 'SAR',
                'symbol' => 'ر.س',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => 1,
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'company_id' => 1,
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
                'company_id' => 1,
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
                'company_id' => 1,
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
                'company_id' => 1,
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
                'company_id' => 1,
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
                'company_id' => 1,
                'name_en' => 'Pending',
                'name_ar' => 'قيد الانتظار',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'name_en' => 'Completed',
                'name_ar' => 'مكتمل',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'name_en' => 'Failed',
                'name_ar' => 'فشل',
                'color' => '#e74c3c',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => 1,
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
                'company_id' => 1,
                'name_en' => 'New',
                'name_ar' => 'جديد',
                'color' => '#3498db',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'name_en' => 'Processing',
                'name_ar' => 'قيد المعالجة',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => 1,
                'name_en' => 'Shipped',
                'name_ar' => 'تم الشحن',
                'color' => '#9b59b6',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => 1,
                'name_en' => 'Delivered',
                'name_ar' => 'تم التسليم',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'company_id' => 1,
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
     * Seed the taxes table.
     */
    private function seedTaxes()
    {
        $this->command->info('Seeding taxes...');

        $taxes = [
            [
                'id' => 1,
                'name_en' => 'VAT',
                'name_ar' => 'ضريبة القيمة المضافة',
                'type' => 'percentage',
                'amount' => 15.00,
                'company_id' => 1,
                'is_active' => 1,
                'created_at' => '2025-05-18 13:02:17',
                'updated_at' => '2025-05-18 13:02:17',
                'deleted_at' => null
            ]
        ];

        foreach ($taxes as $tax) {
            DB::table('taxes')->updateOrInsert(
                ['id' => $tax['id']],
                $tax
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
                'company_id' => 1,
                'key' => 'default_currency',
                'value_en' => 'SAR',
                'value_ar' => 'ر.س',
                'field_type' => 'currency',
                'created_at' => '2025-05-04 08:45:11',
                'updated_at' => '2025-05-04 08:45:11'
            ],
            [
                'id' => 2,
                'company_id' => 1,
                'key' => 'default_payment_methode',
                'value_en' => 'Cash on Delivery',
                'value_ar' => 'الدفع عند الاستلام',
                'field_type' => 'payment_method',
                'created_at' => '2025-05-04 09:44:22',
                'updated_at' => '2025-05-04 09:46:18'
            ],
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
                'value_en' => 'thank you for purchasing with us',
                'value_ar' => 'شكرا لك على الشراء معنا',
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

    /**
     * Seed the roles and permissions tables.
     */
    private function seedRolesAndPermissions()
    {
        $this->command->info('Seeding roles and permissions...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data
        DB::table('model_has_roles')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Insert roles
        $roles = [
            ['id' => 1, 'name' => 'super_admin', 'guard_name' => 'web', 'created_at' => '2025-05-26 12:15:04', 'updated_at' => '2025-05-26 12:15:04'],
            ['id' => 2, 'name' => 'point_of_sale', 'guard_name' => 'web', 'created_at' => '2025-05-26 12:44:29', 'updated_at' => '2025-05-26 12:44:29'],
            ['id' => 3, 'name' => 'admin', 'guard_name' => 'web', 'created_at' => '2025-05-26 14:26:34', 'updated_at' => '2025-05-26 14:26:34']
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        // Insert permissions
        $baseTimestamp = '2025-05-26 12:15:04';
        $permissions = [];

        // Helper function to generate CRUD permissions for a resource
        $generateCrudPermissions = function($resource, $startId) use ($baseTimestamp, &$permissions) {
            $actions = [
                'view', 'view_any', 'create', 'update', 'restore', 'restore_any',
                'replicate', 'reorder', 'delete', 'delete_any', 'force_delete', 'force_delete_any'
            ];

            foreach ($actions as $index => $action) {
                $permissions[] = [
                    'id' => $startId + $index,
                    'name' => "{$action}_{$resource}",
                    'guard_name' => 'web',
                    'created_at' => $baseTimestamp,
                    'updated_at' => $baseTimestamp
                ];
            }
            return count($actions);
        };

        // Generate permissions for all resources
        $currentId = 1;
        $currentId += $generateCrudPermissions('address::type', $currentId);
        $currentId += $generateCrudPermissions('company', $currentId);
        $currentId += $generateCrudPermissions('currency', $currentId);
        $currentId += $generateCrudPermissions('customer', $currentId);
        $currentId += $generateCrudPermissions('invoice', $currentId);
        $currentId += $generateCrudPermissions('invoice::template::setting', $currentId);
        $currentId += $generateCrudPermissions('order', $currentId);
        $currentId += $generateCrudPermissions('order::status', $currentId);
        $currentId += $generateCrudPermissions('payment::method', $currentId);
        $currentId += $generateCrudPermissions('payment::status', $currentId);
        $currentId += $generateCrudPermissions('point::of::sale', $currentId);
        $currentId += $generateCrudPermissions('product', $currentId);
        $currentId += $generateCrudPermissions('product::category', $currentId);

        // Role permissions
        $rolePermissions = [
            'view', 'view_any', 'create', 'update', 'delete', 'delete_any'
        ];
        foreach ($rolePermissions as $index => $action) {
            $permissions[] = [
                'id' => $currentId + $index,
                'name' => "{$action}_role",
                'guard_name' => 'web',
                'created_at' => $baseTimestamp,
                'updated_at' => $baseTimestamp
            ];
        }
        $currentId += count($rolePermissions);

        // Settings permissions
        $currentId += $generateCrudPermissions('setting', $currentId);

        // Tax permissions
        $currentId += $generateCrudPermissions('tax', $currentId);

        // User permissions
        $currentId += $generateCrudPermissions('user', $currentId);

        // Widget permission
        $permissions[] = [
            'id' => 199,
            'name' => 'widget_BusinessMetricsWidget',
            'guard_name' => 'web',
            'created_at' => $baseTimestamp,
            'updated_at' => $baseTimestamp
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        // Insert role has permissions
        $rolePermissionMappings = [];

        // Super admin gets all permissions
        for ($i = 1; $i <= 199; $i++) {
            $rolePermissionMappings[] = ['permission_id' => $i, 'role_id' => 1];
        }

        // Point of sale permissions
        $pointOfSalePermissionIds = [
            // Customer permissions
            37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48,
            // Invoice permissions
            49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60,
            // Invoice template settings permissions
            61, 62,
            // Order permissions
            73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84,
            // Product permissions
            133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144,
            // Product category permissions
            145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156,
            // Settings view permissions
            163, 164,
            // Tax view permissions
            175, 176,
            // Widget permission
            199
        ];

        foreach ($pointOfSalePermissionIds as $permissionId) {
            $rolePermissionMappings[] = ['permission_id' => $permissionId, 'role_id' => 2];
        }

        // Admin permissions
        $adminPermissionIds = [
            // Currency permissions
            25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36,
            // Customer permissions
            37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48,
            // Invoice permissions
            49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60,
            // Invoice template settings permissions
            61, 62, 64,
            // Order permissions
            73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84,
            // Order status permissions
            85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96,
            // Payment method permissions
            97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108,
            // Point of sale permissions
            121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132,
            // Product permissions
            133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144,
            // Product category permissions
            145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156,
            // Settings permissions
            163, 164, 166,
            // Tax permissions
            175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 186,
            // User permissions
            187, 188, 189, 190, 191, 192, 193, 194, 195, 196, 197, 198,
            // Widget permission
            199
        ];

        foreach ($adminPermissionIds as $permissionId) {
            $rolePermissionMappings[] = ['permission_id' => $permissionId, 'role_id' => 3];
        }

        foreach ($rolePermissionMappings as $mapping) {
            DB::table('role_has_permissions')->insert($mapping);
        }
    }

    /**
     * Seed the users table and assign roles.
     */
    private function seedUsers()
    {
        $this->command->info('Seeding users and assigning roles...');

        $adminEmail = self::$emailOverride ?: 'admin@gmail.com';
        $superAdminEmail = str_contains($adminEmail, 'admin') ? str_replace('admin', 'super_admin', $adminEmail) : 'super_admin_' . $adminEmail;
        $adminPassword = self::$passwordOverride ? bcrypt(self::$passwordOverride) : bcrypt('12345678');

        $super_admin = User::updateOrCreate(
            ['email' => $superAdminEmail],
            [
               'company_id' => null,
               'point_of_sale_id' => null,
               'first_name' =>  'Super',
               'last_name' =>  'Admin',
               'password' => $adminPassword
            ]
        );
        $super_admin->assignRole('super_admin');

        $admin = User::updateOrCreate(
            ['email' => $adminEmail],
            [
               'company_id' => 1,
               'point_of_sale_id' => null,
               'first_name' =>  'Mr.',
               'last_name' =>  'Admin',
               'password' => $adminPassword
            ]
        );
        $admin->assignRole('admin');

        $this->command->info('Super admin user created/updated and role assigned.');
    }
}
