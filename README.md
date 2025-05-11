# Invoices Manager

## Project Setup Guide

### Initial Setup Steps

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd [project-directory]
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Setup**
   - Copy `.env.example` to `.env`
   - Configure your database settings in `.env`
   - Generate application key:
     ```bash
     php artisan key:generate
     ```

4. **Database Setup**
   ```bash
   php artisan migrate
   ```

5. **Create Super Admin**
   ```bash
   php artisan shield:super-admin
   ```

6. **Generate Permissions**
   ```bash
   php artisan shield:generate --option=permissions --all
   ```

7. **Seed Permissions**
   ```bash
   php artisan db:seed --class=ShieldSeeder
   ```

8. **Seed Initial Data**
   ```bash
   php artisan db:seed --class=initialDataSeeder
   ```

### System Configuration

After completing the setup, you can now:

1. **Login as Super Admin**
   - Use the super admin credentials to access the system

2. **Configure System Settings**
   - Navigate to Other Settings
   - Add the following settings:
     - `logo_dark`: Upload your dark mode logo
     - `logo_light`: Upload your light mode logo
     - `default_currency`: Set your default currency (e.g., SAR)
     - Configure any other required settings

3. **Create Point of Sale (POS)**
   - Navigate to the POS section
   - Create a new POS with required details

4. **Create Company**
   - Navigate to the Companies section
   - Create a new company with all required details

5. **Add POS to Company**
   - Edit the created POS
   - Assign it to the company you created

6. **Create POS Role**
   - Navigate to Roles & Permissions
   - Create a new role for POS users with appropriate permissions

7. **Create User for POS**
   - Navigate to Users
   - Create a new user
   - Assign the user to:
     - The company you created
     - The POS you created
     - The POS role you created

8. **Provide Access to POS User**
   - Share the email and password with the POS user
   - The POS user can now:
     - Add and manage products
     - Process orders
     - Handle invoices
     - Manage their assigned point of sale

---

# Original Project Documentation

I'm building a SAAS Laravel app as the following:
The list of entities is:
User:


Address:
    protected $fillable = [
        'address_type_id',
        'addressable_type',
        'addressable_id',
        'contact_person_full_name', // nullable
        'contact_person_phone', // nullable
        'street',
        'postal_code', // nullable
        'country_id',
        'latitude', // nullable
        'longitude', // nullable
        'details', // nullable
    ];

AddressType:
    const SHIPPING = 1;
    const BILLING = 2;

    protected $fillable = [
        'name_en',
        'name_ar',
    ];

Company:
    protected $fillable = [
        'legal_name',
        'tax_number',
        'website',
        'email',
        'phone',
        'logo',
        'is_active',
    ];

Currency:
    protected $fillable = [
        'name',
        'code',
        'symbol',
    ];

PointOfSale:
    protected $fillable = [
        'name',
        'company_id',
        'is_active'
    ];

Note:
    protected $fillable = [
        'note',
        'notable_type',
        'notable_id',
    ];

OrderStatus:
    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
    ];


Order:
    protected $fillable = [
        'number',
        'customer_name',
        'customer_email',
        'customer_phone_number',
        'customer_id',              // id in users table
        'company_id',               // id in companies table
        'company_vat_number',
        'order_status_id',
        'shipping_fee', // big integer because it is stored as Dollar and Cent
        'subtotal', // big integer because it is stored as Dollar and Cent
        'tax', // big integer because it is stored as Dollar and Cent
        'total', // big integer because it is stored as Dollar and Cent
        'payment_method_id',
        'currency_id',
        'billing_address_id',
        'shipping_address_id',
        'estimated_delivery_at', // nullable date and tinme
        'delivered_at', // nullable date and tinme
        'shipped_at', // nullable date and tinme
    ];


OrderItem:
    protected $fillable = [
        'order_id',
        'product_name_en',
        'product_name_ar',
        'product_description_en', // nullable
        'product_description_ar', // nullable
        'product_sku', // nullable
        'product_code', // nullable
        'product_id', // set to null on delete
        'quantity', // big integer and stored as Dollar and Cent
        'unit_price', // big integer and stored as Dollar and Cent
        'tax_id', // set to null on delete
        'tax_amount', // big integer and stored as Dollar and Cent
        'discount_amount', // big integer and stored as Dollar and Cent
        'total_price', // big integer and stored as Dollar and Cent
    ];


ProductCategory:
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'parent_id',
    ];


Product:
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'slug',
        'sku', // nullable
        'code', // nullable
        'price', // big integer and stored as Dollar and Cent
        'sale_price', // nullable and big integer and stored as Dollar and Cent
        'currency_id',
        'product_category_id',
        'company_id',
        'image_url', // nullable string
    ];

InvoiceStatus:
    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
    ];

Invoice:
    protected $fillable = [
        'number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'company_id',
        'customer_id',
        'billing_address_id',
        'shipping_address_id',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'issue_date', // date and time
        'due_date', // nullable date and time
        'paid_date', // nullable date and time
        'invoice_status_id',
        'currency_id',
        'issued_by_user'
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'due_date' => 'datetime',
        'paid_date' => 'datetime',
    ];

InvoiceItem:
    protected $fillable = [
        'invoice_id',
        'invoiceable_item_type',
        'invoiceable_item_id',
        'product_name_en',
        'product_name_ar',
        'product_description_en', // nullable
        'product_description_ar', // nullable
        'product_sku', // nullable
        'product_code', // nullable
        'quantity', // integer
        'unit_price', // big integer stored as Dollar and Cent
        'tax_id', // set null on delete
        'tax_amount', // big integer stored as Dollar and Cent
        'discount_amount', // big integer stored as Dollar and Cent
        'subtotal', // big integer stored as Dollar and Cent
        'total', // big integer stored as Dollar and Cent
        'is_active',
    ];

PaymentMethod:
    protected $fillable = [
        'name_en',
        'name_ar',
        'code',
        'icon',
    ];

PaymentStatus:
    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
    ];

TransactionStatus:
    protected $fillable = [
        'name_en',
        'name_ar',
        'color',
    ];

Transaction:
    protected $fillable = [
        'transaction_id', // string
        'date', nullable date and time
        'transaction_status_id'
    ];
Tax:
    protected $fillable = [
        'name',
        'type', // percentage or fixed
        'amount', // big integer
        'is_active',
    ];

Each PointOfSale has Company information so the Company data must be stored separately and each PointOfSale has an Address and each Company has an Address and each PointOfSale has a set of Product and each User Belongs to a Company and can have many Order

Address can belong to any entity (polymorphic relationship): Company, PointOfSale, User, ... etc
Any entity can have many Note (polymorphic relationship): Company, Order, ... etc
Each Product belongs to a ProductCategory
Order belongs to OrderStatus: new, in_progress, completed, ... etc
Order has many OrderItem
Invoice belongs to InvoiceStatus
Invoice has many InvoiceItem
InvoiceItem can belong to any entity (morph to)
Each Invoice can have many Payment
Each Payment belongs to PaymentStatus
Each Payment belongs to PaymentMethod
Each Payment belongs to Currency
Each Company has many Tax




Migration file:
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->unsignedBigInteger('company_id');
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('address_type_id'); // 1: Shipping, 2: Billing
            $table->morphs('addressable');
            $table->string('street');
            $table->string('postal_code')->nullable();
            $table->unsignedInteger('country_id');
            $table->string('contact_person_full_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('legal_name')->unique();
            $table->string('tax_number')->unique();
            $table->string('website')->nullable();
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('logo')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('point_of_sales', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        Schema::create('point_of_sale_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('point_of_sale_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('point_of_sale_id')->references('id')->on('point_of_sales')->onDelete('cascade');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone_number');
            $table->unsignedBigInteger('company_id');
            $table->unsignedInteger('order_status_id');
            $table->unsignedBigInteger('shipping_fee');
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('tax');
            $table->unsignedBigInteger('total');
            $table->unsignedInteger('payment_method_id');
            $table->unsignedInteger('currency_id');
            $table->unsignedBigInteger('billing_address_id')->nullable();
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->timestamp('estimated_delivery_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('billing_address_id');
            $table->unsignedBigInteger('shipping_address_id')->nullable();
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('tax_amount');
            $table->unsignedBigInteger('discount_amount');
            $table->unsignedBigInteger('total_amount');
            $table->timestamp('issue_date');
            $table->timestamp('due_date')->nullable();
            $table->timestamp('paid_date')->nullable();
            $table->unsignedInteger('invoice_status_id');
            $table->unsignedInteger('currency_id');
            $table->unsignedBigInteger('issued_by_user');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->morphs('invoiceable_item');
            $table->string('product_name_en');
            $table->string('product_name_ar');
            $table->string('product_sku')->nullable();
            $table->string('product_code')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('unit_price');
            $table->unsignedBigInteger('tax_amount')->default(0);
            $table->unsignedBigInteger('discount_amount')->default(0);
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('total');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('payment_status_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('amount');
            $table->timestamp('payment_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->unique();
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('transaction_status_id');
            $table->json('meta_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('transaction_status_id')->references('id')->on('transaction_statuses');
        });

        Schema::create('payment_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('color');
            $table->timestamps();
        });

        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['percentage', 'fixed']);
            $table->unsignedBigInteger('amount');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('transaction_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name_en');
            $table->string('name_ar');
            $table->string('color');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('transactions');
    }
};
