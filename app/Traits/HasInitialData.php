<?php

namespace App\Traits;

use App\Models\AddressType;
use App\Models\Currency;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\InvoiceTemplateSetting;
use App\Models\Tax;
use Illuminate\Support\Facades\DB;

trait HasInitialData
{
    public function seedInitialData()
    {
        \DB::beginTransaction();
        try {
            // $this->seedAddressTypes();
            $this->seedCurrencies();
            $this->seedPaymentMethods();
            $this->seedPaymentStatuses();
            $this->seedOrderStatuses();
            $this->seedSettings();
            $this->seedInvoiceTemplateSettings();
            $this->seedTaxes();

            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollBack();
            throw $e;
        }
    }

    // protected function seedAddressTypes()
    // {
    //     $addressTypes = [
    //         [
    //             'id' => 1,
    //             'company_id' => $this->id,
    //             'name_en' => 'Shipping',
    //             'name_ar' => 'شحن',
    //             'created_at' => '2025-03-23 17:14:16',
    //             'updated_at' => '2025-03-23 17:14:16'
    //         ],
    //         [
    //             'id' => 2,
    //             'company_id' => $this->id,
    //             'name_en' => 'Billing',
    //             'name_ar' => 'فواتير',
    //             'created_at' => '2025-03-23 17:14:16',
    //             'updated_at' => '2025-03-23 17:14:16'
    //         ]
    //     ];

    //     foreach ($addressTypes as $type) {
    //         AddressType::create($type);
    //     }
    // }

    protected function seedCurrencies()
    {
        $currencies = [
            [
                'id' => 1,
                'company_id' => $this->id,
                'name' => 'Saudi Riyal',
                'code' => 'SAR',
                'symbol' => 'ر.س',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => $this->id,
                'name' => 'US Dollar',
                'code' => 'USD',
                'symbol' => '$',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => $this->id,
                'name' => 'Euro',
                'code' => 'EUR',
                'symbol' => '€',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => $this->id,
                'name' => 'British Pound',
                'code' => 'GBP',
                'symbol' => '£',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'company_id' => $this->id,
                'name' => 'Pakistani Rupees',
                'code' => 'PKR',
                'symbol' => 'Rs',
                'created_at' => '2025-05-04 08:38:26',
                'updated_at' => '2025-05-04 08:38:26',
                'deleted_at' => null
            ]
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }

    protected function seedPaymentMethods()
    {
        $paymentMethods = [
            [
                'id' => 1,
                'company_id' => $this->id,
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
                'company_id' => $this->id,
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
                'company_id' => $this->id,
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
                'company_id' => $this->id,
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
            PaymentMethod::create($method);
        }
    }

    protected function seedPaymentStatuses()
    {
        $paymentStatuses = [
            [
                'id' => 1,
                'company_id' => $this->id,
                'name_en' => 'Pending',
                'name_ar' => 'قيد الانتظار',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => $this->id,
                'name_en' => 'Completed',
                'name_ar' => 'مكتمل',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => $this->id,
                'name_en' => 'Failed',
                'name_ar' => 'فشل',
                'color' => '#e74c3c',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => $this->id,
                'name_en' => 'Refunded',
                'name_ar' => 'مسترجع',
                'color' => '#3498db',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ]
        ];

        foreach ($paymentStatuses as $status) {
            PaymentStatus::create($status);
        }
    }

    protected function seedOrderStatuses()
    {
        $orderStatuses = [
            [
                'id' => 1,
                'company_id' => $this->id,
                'name_en' => 'New',
                'name_ar' => 'جديد',
                'color' => '#3498db',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 2,
                'company_id' => $this->id,
                'name_en' => 'Processing',
                'name_ar' => 'قيد المعالجة',
                'color' => '#f39c12',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 3,
                'company_id' => $this->id,
                'name_en' => 'Shipped',
                'name_ar' => 'تم الشحن',
                'color' => '#9b59b6',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 4,
                'company_id' => $this->id,
                'name_en' => 'Delivered',
                'name_ar' => 'تم التسليم',
                'color' => '#2ecc71',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ],
            [
                'id' => 5,
                'company_id' => $this->id,
                'name_en' => 'Cancelled',
                'name_ar' => 'ملغي',
                'color' => '#e74c3c',
                'created_at' => '2025-03-23 17:14:16',
                'updated_at' => '2025-03-23 17:14:16',
                'deleted_at' => null
            ]
        ];

        foreach ($orderStatuses as $status) {
            OrderStatus::create($status);
        }
    }

    protected function seedSettings()
    {
        $settings = [
            [
                'id' => 1,
                'company_id' => $this->id,
                'key' => 'default_currency',
                'value_en' => 'SAR',
                'value_ar' => 'ر.س',
                'field_type' => 'currency',
                'created_at' => '2025-05-04 08:45:11',
                'updated_at' => '2025-05-04 08:45:11'
            ],
            [
                'id' => 2,
                'company_id' => $this->id,
                'key' => 'default_payment_methode',
                'value_en' => 'Cash on Delivery',
                'value_ar' => 'الدفع عند الاستلام',
                'field_type' => 'payment_method',
                'created_at' => '2025-05-04 09:44:22',
                'updated_at' => '2025-05-04 09:46:18'
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }

    protected function seedInvoiceTemplateSettings()
    {
        $invoiceTemplateSettings = [
            [
                'id' => 2,
                'company_id' => $this->id,
                'key_name' => 'note',
                'field_type' => 'rich_text_editor',
                'value_en' => '<p><strong>SNAP:</strong> NOHAALNAMLAH<br> <strong>INSTAGRAM:</strong> NOHAALNAMLAH&nbsp;</p><p><strong>Bank Details:</strong><br> <strong>Account Holder:</strong> Noha Alnamlah<br> <strong>Bank Name:</strong> Al Rajhi Bank<br> <strong>Account Number:</strong> SA9080000462608010203090&nbsp;</p>',
                'value_ar' => '<p dir="rtl">&nbsp;<strong>سناب:</strong> NOHAALNAMLAH<br> <strong>إنستجرام:</strong> NOHAALNAMLAH&nbsp;</p><p dir="rtl"><strong>تفاصيل الحساب البنكي:</strong><br> <strong>اسم صاحب الحساب:</strong> نهى النملة<br> <strong>اسم البنك:</strong> بنك الراجحي<br> <strong>رقم الحساب:</strong> SA9080000462608010203090&nbsp;</p>',
                'created_at' => '2025-05-11 08:33:27',
                'updated_at' => '2025-05-17 07:29:07'
            ],
            [
                'id' => 3,
                'company_id' => $this->id,
                'key_name' => 'logo',
                'field_type' => 'image',
                'value_en' => 'settings/01JVEK010YFD6JK6JGFX0TRN17.jpeg',
                'value_ar' => 'settings/01JVEK0112P8YVDQKD1F74ABWD.jpeg',
                'created_at' => '2025-05-17 07:40:33',
                'updated_at' => '2025-05-17 07:40:33'
            ],
            [
                'id' => 4,
                'company_id' => $this->id,
                'key_name' => 'show_customer_address',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:33:54',
                'updated_at' => '2025-05-17 08:32:43'
            ],
            [
                'id' => 5,
                'company_id' => $this->id,
                'key_name' => 'show_customer_phone_number',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:34:06',
                'updated_at' => '2025-05-17 08:32:49'
            ],
            [
                'id' => 6,
                'company_id' => $this->id,
                'key_name' => 'show_customer_vat',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:34:52',
                'updated_at' => '2025-05-17 08:32:53'
            ],
            [
                'id' => 7,
                'company_id' => $this->id,
                'key_name' => 'show_company_vat',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:11',
                'updated_at' => '2025-05-17 08:32:56'
            ],
            [
                'id' => 8,
                'company_id' => $this->id,
                'key_name' => 'show_company_email',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:25',
                'updated_at' => '2025-05-17 08:33:00'
            ],
            [
                'id' => 9,
                'company_id' => $this->id,
                'key_name' => 'show_company_address',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:35:51',
                'updated_at' => '2025-05-17 08:33:18'
            ],
            [
                'id' => 10,
                'company_id' => $this->id,
                'key_name' => 'invoice_title',
                'field_type' => 'text',
                'value_en' => 'VAT Invoice',
                'value_ar' => 'فاتورة مبيعات ضريبية',
                'created_at' => '2025-05-17 07:38:11',
                'updated_at' => '2025-05-17 08:48:54'
            ],
            [
                'id' => 11,
                'company_id' => $this->id,
                'key_name' => 'order_invoice_title',
                'field_type' => 'text',
                'value_en' => 'Quotation',
                'value_ar' => 'عرض سعر',
                'created_at' => '2025-05-17 07:39:25',
                'updated_at' => '2025-05-17 08:47:21'
            ],
            [
                'id' => 12,
                'company_id' => $this->id,
                'key_name' => 'show_customer_email',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 07:33:09',
                'updated_at' => '2025-05-17 08:32:39'
            ],
            [
                'id' => 13,
                'company_id' => $this->id,
                'key_name' => 'show_company_phone_number',
                'field_type' => 'checkbox',
                'value_en' => '1',
                'value_ar' => '1',
                'created_at' => '2025-05-17 10:17:32',
                'updated_at' => '2025-05-17 10:17:32'
            ]
        ];

        foreach ($invoiceTemplateSettings as $setting) {
            InvoiceTemplateSetting::create($setting);
        }
    }

    protected function seedTaxes()
    {
        $taxes = [
            [
                'id' => 1,
                'company_id' => $this->id,
                'name_en' => 'VAT',
                'name_ar' => 'ضريبة القيمة المضافة',
                'type' => 'percentage',
                'amount' => 15.00,
                'is_active' => 1,
                'created_at' => '2025-05-18 13:06:29',
                'updated_at' => '2025-05-18 13:06:29',
                'deleted_at' => null
            ]
        ];

        foreach ($taxes as $tax) {
            Tax::create($tax);
        }
    }
}
