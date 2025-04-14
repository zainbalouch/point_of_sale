<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Currency;
use App\Models\Product;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->label(__('Order Information'))
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label(__('Order Number'))
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder(__('Will be auto-generated'))
                            ->maxLength(255),
                    ]),

                Forms\Components\Section::make(__('Point of Sale Information'))
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'legal_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                if ($user->point_of_sale_id) {
                                    return \App\Models\PointOfSale::find($user->point_of_sale_id)?->company_id;
                                }
                                return null;
                            })
                            ->disabled(function () {
                                $user = Filament::auth()->user();
                                return $user->point_of_sale_id !== null;
                            })
                            ->dehydrated()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $set('point_of_sale_id', null);
                            }),
                        Forms\Components\Select::make('point_of_sale_id')
                            ->relationship('pointOfSale', 'name_' . app()->getLocale())
                            ->searchable()
                            ->preload()
                            ->required()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                return $user->point_of_sale_id;
                            })
                            ->disabled(function () {
                                $user = Filament::auth()->user();
                                return $user->point_of_sale_id !== null;
                            })
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Customer Information'))
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship(
                                name: 'customer',
                                modifyQueryUsing: function (Builder $query) {
                                    $user = Filament::auth()->user();
                                    if ($user->point_of_sale_id) {
                                        return $query->where('point_of_sale_id', $user->point_of_sale_id);
                                    }
                                    return $query;
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->label(__('Customer'))
                            ->required()
                            ->live()
                            ->afterStateHydrated(function ($state, Forms\Set $set) {
                                if (!$state) return;

                                $customer = \App\Models\Customer::find($state);
                                if ($customer) {
                                    $set('customer_name', "{$customer->first_name} {$customer->last_name}");
                                    $set('customer_email', $customer->email);
                                    $set('customer_phone_number', $customer->phone_number);
                                }
                            })
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    $set('customer_name', null);
                                    $set('customer_email', null);
                                    $set('customer_phone_number', null);
                                    return;
                                }

                                $customer = \App\Models\Customer::find($state);
                                if ($customer) {
                                    $set('customer_name', "{$customer->first_name} {$customer->last_name}");
                                    $set('customer_email', $customer->email);
                                    $set('customer_phone_number', $customer->phone_number);
                                }
                            })
                            ->createOptionForm([
                                Forms\Components\Section::make(__('Personal Information'))
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('first_name')
                                                    ->label(__('First Name'))
                                                    ->required()
                                                    ->maxLength(255),

                                                Forms\Components\TextInput::make('last_name')
                                                    ->label(__('Last Name'))
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->columns(2),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('email')
                                                    ->label(__('Email'))
                                                    ->email()
                                                    ->maxLength(255)
                                                    ->unique('customers', 'email'),

                                                Forms\Components\TextInput::make('phone_number')
                                                    ->label(__('Phone Number'))
                                                    ->tel()
                                                    ->required()
                                                    ->maxLength(20),
                                            ])
                                            ->columns(2),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('vat_number')
                                                    ->label(__('VAT Number'))
                                                    ->maxLength(255),

                                                Forms\Components\TextInput::make('address')
                                                    ->label(__('Address'))
                                                    ->maxLength(1000),
                                            ])
                                            ->columns(2),
                                    ]),

                                Forms\Components\Section::make(__('Company & Settings'))
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('company_id')
                                                    ->label(__('Company'))
                                                    ->relationship('company', 'legal_name')
                                                    ->searchable()
                                                    ->preload()
                                                    ->default(function () {
                                                        $user = Filament::auth()->user();
                                                        return $user && $user->company_id ? $user->company_id : null;
                                                    }),

                                                Forms\Components\Toggle::make('is_active')
                                                    ->label(__('Active Status'))
                                                    ->helperText(__('Whether the customer is active'))
                                                    ->default(true),
                                            ])
                                            ->columns(2),
                                    ]),
                            ])
                            ->createOptionModalHeading(__('Create New Customer')),
                        Forms\Components\Select::make('user_id')
                            ->relationship(
                                name: 'user',
                                modifyQueryUsing: fn(Builder $query) => $query
                                    ->select(['id', 'first_name', 'last_name'])
                                    ->orderBy('first_name')
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                            ->label(__('Assigned Staff'))
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->default(fn() => Filament::auth()->id()),
                        Forms\Components\Hidden::make('customer_name')
                            ->dehydrated(),
                        Forms\Components\Hidden::make('customer_email')
                            ->dehydrated(),
                        Forms\Components\Hidden::make('customer_phone_number')
                            ->dehydrated(),
                    ])
                    ->columns(2),


                // Forms\Components\Section::make(__('Financial Details'))
                //     ->schema([
                //         Forms\Components\TextInput::make('shipping_fee')
                //             ->label(__('Shipping Fee'))
                //             ->numeric()
                //             ->minValue(0)
                //             ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                //         Forms\Components\TextInput::make('subtotal')
                //             ->label(__('Subtotal'))
                //             ->numeric()
                //             ->minValue(0)
                //             ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                //         Forms\Components\TextInput::make('vat')
                //             ->label(__('vat'))
                //             ->numeric()
                //             ->minValue(0)
                //             ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                //         Forms\Components\TextInput::make('total')
                //             ->label(__('Total'))
                //             ->numeric()
                //             ->minValue(0)
                //             ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                //             ->dehydrated()
                //             ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, Forms\Get $get) {
                //                 if (blank($state)) {
                //                     $shipping = (float)($get('shipping_fee') ?? 0);
                //                     $subtotal = (float)($get('subtotal') ?? 0);
                //                     $vat = (float)($get('vat') ?? 0);
                //                     $component->state($shipping + $subtotal + $vat);
                //                 }
                //             })
                //             ->live()
                //             ->disabled(),
                //     ])
                //     ->columns(2),

                Forms\Components\Section::make(__('Order Items'))
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\View::make('filament.components.item-headers')
                                    ->viewData([
                                        'headers' => [
                                            ['label' => __('Product'), 'span' => 2, 'padding' => 20],
                                            ['label' => __('Quantity'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Unit Price'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('VAT'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Other Taxes'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Discount'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Total Price'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Note'), 'span' => 2, 'padding' => 20],
                                        ]
                                    ])
                                    ->columnSpanFull(),
                            ])
                            ->columns(10),
                        Forms\Components\Repeater::make('items')
                            ->label(__('Items'))
                            ->hiddenLabel()
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->relationship('product', 'name_en')
                                            ->label(__('Product'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->live()
                                            ->createOptionForm([
                                                Forms\Components\Section::make(__('Product information'))
                                                    ->schema([
                                                        Forms\Components\TextInput::make('name_en')
                                                            ->label(__('Name (English)'))
                                                            ->required()
                                                            ->maxLength(255)
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                                if ($operation !== 'create') {
                                                                    return;
                                                                }

                                                                $set('slug', Str::slug($state));
                                                            }),

                                                        Forms\Components\TextInput::make('name_ar')
                                                            ->label(__('Name (Arabic)'))
                                                            ->maxLength(255),

                                                        Forms\Components\Textarea::make('description_en')
                                                            ->label(__('Description (English)'))
                                                            ->maxLength(65535)
                                                            ->nullable(),

                                                        Forms\Components\Textarea::make('description_ar')
                                                            ->label(__('Description (Arabic)'))
                                                            ->maxLength(65535)
                                                            ->nullable(),

                                                        Forms\Components\TextInput::make('slug')
                                                            ->label(__('Slug'))
                                                            ->required()
                                                            ->unique('products', 'slug')
                                                            ->maxLength(255),

                                                        Forms\Components\TextInput::make('sku')
                                                            ->label(__('SKU'))
                                                            ->unique('products', 'sku')
                                                            ->maxLength(255),

                                                        Forms\Components\TextInput::make('code')
                                                            ->label(__('Code'))
                                                            ->unique('products', 'code')
                                                            ->maxLength(255),

                                                        Forms\Components\Select::make('product_category_id')
                                                            ->label(__('Product Category'))
                                                            ->relationship('category', 'name_' . app()->getLocale())
                                                            ->required()
                                                            ->searchable()
                                                            ->preload(),

                                                        Forms\Components\Select::make('currency_id')
                                                            ->label(__('Currency'))
                                                            ->relationship('currency', 'code')
                                                            ->required()
                                                            ->searchable()
                                                            ->preload()
                                                            ->default(fn() => Currency::where('code', 'SAR')->first()?->id),

                                                        Forms\Components\TextInput::make('price')
                                                            ->label(__('Price'))
                                                            ->numeric()
                                                            ->required()
                                                            ->minValue(0)
                                                            ->step(0.01)
                                                            ->live()
                                                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get)),

                                                        Forms\Components\Select::make('company_id')
                                                            ->label(__('Company'))
                                                            ->relationship('company', 'legal_name')
                                                            ->required()
                                                            ->searchable()
                                                            ->preload()
                                                            ->default(function () {
                                                                $user = Filament::auth()->user();
                                                                return $user && $user->company_id ? $user->company_id : null;
                                                            }),

                                                        Forms\Components\CheckboxList::make('taxes')
                                                            ->label(__('Taxes'))
                                                            ->relationship(
                                                                'taxes',
                                                                fn() => app()->getLocale() === 'en' ? 'name_en' : 'name_ar'
                                                            )
                                                            ->options(function () {
                                                                $companyId = Filament::auth()->user()->company_id;
                                                                if (!$companyId) {
                                                                    return [];
                                                                }

                                                                return \App\Models\Tax::query()
                                                                    ->where('company_id', $companyId)
                                                                    ->where('is_active', true)
                                                                    ->pluck(app()->getLocale() === 'en' ? 'name_en' : 'name_ar', 'id')
                                                                    ->toArray();
                                                            })
                                                            ->columns(2)
                                                            ->live()
                                                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get)),

                                                        Forms\Components\TextInput::make('sale_price')
                                                            ->label(__('Sale price (with taxes)'))
                                                            ->numeric()
                                                            ->disabled()
                                                            ->dehydrated(true)
                                                            ->step(0.01),
                                                    ])
                                                    ->columns(2),
                                            ])
                                            ->createOptionModalHeading(__('Create New Product'))
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                if (!$state) return;

                                                $product = Product::find($state);
                                                if (!$product) return;

                                                // Clear previous values first
                                                $set('product_name_en', null);
                                                $set('product_name_ar', null);
                                                $set('product_description_en', null);
                                                $set('product_description_ar', null);
                                                $set('product_sku', null);
                                                $set('unit_price', null);
                                                $set('vat_amount', 0);
                                                $set('other_taxes_amount', 0);

                                                // Set new values
                                                $set('product_name_en', $product->name_en);
                                                $set('product_name_ar', $product->name_ar);
                                                $set('product_description_en', $product->description_en);
                                                $set('product_description_ar', $product->description_ar);
                                                $set('product_sku', $product->sku);
                                                $set('unit_price', $product->price);

                                                // Calculate vates
                                                $vatAmount = $product->getVatAmount();
                                                // Preserve decimals with exact precision
                                                $set('vat_amount', number_format($vatAmount, 2, '.', ''));

                                                // Calculate other taxes
                                                $otherTaxesAmount = $product->getOtherTaxesAmount();
                                                $set('other_taxes_amount', number_format($otherTaxesAmount, 2, '.', ''));

                                                // Calculate initial total price
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($product->price);
                                                $vatAmount = floatval($vatAmount);
                                                $otherTaxesAmount = floatval($otherTaxesAmount);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('quantity')
                                            ->label(__('Quantity'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($state ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $vatAmount = floatval($get('vat_amount') ?? 0);
                                                $otherTaxesAmount = floatval($get('other_taxes_amount') ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('unit_price')
                                            ->label(__('Unit Price'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($state ?? 0);
                                                $vatAmount = floatval($get('vat_amount') ?? 0);
                                                $otherTaxesAmount = floatval($get('other_taxes_amount') ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('vat_amount')
                                            ->label(__('VAT'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->step(0.1)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $vatAmount = floatval($state ?? 0);
                                                $otherTaxesAmount = floatval($get('other_taxes_amount') ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('other_taxes_amount')
                                            ->label(__('Other Taxes'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->step(0.1)
                                            ->default(0)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $vatAmount = floatval($get('vat_amount') ?? 0);
                                                $otherTaxesAmount = floatval($state ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('discount_amount')
                                            ->label(__('Discount'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->step(0.1)
                                            ->default(0)
                                            ->minValue(0)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $vatAmount = floatval($get('vat_amount') ?? 0);
                                                $otherTaxesAmount = floatval($get('other_taxes_amount') ?? 0);
                                                $discountAmount = floatval($state ?? 0);
                                                $set('total_price', number_format((($unitPrice + $vatAmount + $otherTaxesAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('total_price')
                                            ->label(__('Total Price'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
                                            ->step(0.1)
                                            ->minValue(0)
                                            ->disabled()
                                            ->dehydrated()
                                            ->columnSpan(1),
                                        Forms\Components\Textarea::make('note')
                                            ->rows(1)
                                            ->label(__('Note'))
                                            ->hiddenLabel()
                                            ->placeholder(__('Add a note for this item'))
                                            ->nullable()
                                            ->dehydrated(true)
                                            ->columnSpan(2),
                                    ])
                                    ->columns(10),
                                Forms\Components\Hidden::make('product_name_en')
                                    ->nullable(),
                                Forms\Components\Hidden::make('product_name_ar')
                                    ->nullable(),
                                Forms\Components\Hidden::make('product_description_en')
                                    ->nullable(),
                                Forms\Components\Hidden::make('product_description_ar')
                                    ->nullable(),
                                Forms\Components\Hidden::make('product_sku')
                                    ->nullable(),
                            ])
                            ->defaultItems(1)
                            ->reorderable(false)
                            ->cloneable()
                            ->itemLabel(function (array $state): ?string {
                                $productName = $state['product_name_en'] ?? null;
                                $quantity = $state['quantity'] ?? 0;
                                $totalPrice = $state['total_price'] ?? 0;
                                if (!$productName) return null;

                                return "{$productName}: {$quantity} " . __('units') . " | " . __('Total amount') . ": {$totalPrice}";
                            })
                            ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get) {
                                self::calculateOrderTotalsOnRepeaterUpdate($set, $get);
                            })
                            ->live(onBlur: true),

                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\Placeholder::make('summary_heading')
                                    ->label('')
                                    ->content(__('Order Summary'))
                                    ->extraAttributes(['class' => 'text-xl font-bold pb-2'])
                                    ->columnSpanFull(),

                                // Left Column
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('order_status_id')
                                            ->relationship('status', 'name_en')
                                            ->label(__('Order Status'))
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->default(fn() => \App\Models\OrderStatus::where('name_en', 'New')->first()?->id),
                                        Forms\Components\Select::make('payment_method_id')
                                            ->relationship('paymentMethod', 'name_en')
                                            ->label(__('Payment Method'))
                                            ->required()
                                            ->searchable()
                                            ->preload(),
                                        Forms\Components\Select::make('currency_id')
                                            ->relationship('currency', 'code')
                                            ->label(__('Currency'))
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->default(fn() => Currency::where('code', 'SAR')->first()?->id),
                                        Forms\Components\TextInput::make('amount_paid')
                                            ->label(__('Amount Paid'))
                                            ->numeric()
                                            ->required()
                                            ->minValue(0)
                                            ->step(0.1)
                                            ->default(0)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $amountPaid = floatval($state ?? 0);
                                                $total = floatval($get('total') ?? 0);
                                                $balanceLeft = $total - $amountPaid;
                                                $set('balance_left', number_format($balanceLeft, 2, '.', ''));
                                            })
                                            ->dehydrated(true),
                                        Forms\Components\TextInput::make('balance_left')
                                            ->label(__('Balance Left'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                            ->extraAttributes(['class' => 'text-danger-600 font-bold']),
                                    ])
                                    ->columnSpan(['md' => 6])
                                    ->columns(1),

                                // Right Column
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('subtotal')
                                            ->label(__('Subtotal'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('vat')
                                            ->label(__('Total VAT Amount'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('other_taxes')
                                            ->label(__('Total Other Taxes'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('discount')
                                            ->label(__('Total Discount'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('total')
                                            ->label(__('Total'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->step(0.1)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                            ->extraAttributes(['class' => 'text-primary-600 font-bold']),
                                    ])
                                    ->columnSpan(['md' => 6])
                                    ->columns(1),
                            ])
                            ->columns(12)
                            ->extraAttributes(['class' => 'border rounded-xl p-4 bg-gray-50 mt-4']),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make(__('Order Details'))
                    ->schema([
                        Forms\Components\DateTimePicker::make('estimated_delivery_at')
                            ->label(__('Estimated Delivery At')),
                        Forms\Components\DateTimePicker::make('shipped_at')
                            ->label(__('Shipped At'))
                            ->nullable(),
                        Forms\Components\DateTimePicker::make('delivered_at')
                            ->label(__('Delivered At'))
                            ->nullable(),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->collapsed(),

                Forms\Components\Section::make(__('Shipping Address'))
                    ->relationship('shippingAddress')
                    ->schema([
                        Forms\Components\Hidden::make('address_type_id')
                            ->default(1), // Using numeric value 1 for shipping address type
                        Forms\Components\Section::make(__('Contact Information'))
                            ->schema([
                                Forms\Components\TextInput::make('contact_person_name')
                                    ->label(__('Contact Name'))
                                    ->maxLength(255)
                                    ->placeholder(__('Enter contact person name')),
                                Forms\Components\TextInput::make('contact_person_phone')
                                    ->label(__('Contact Phone'))
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(20)
                                    ->placeholder('+1 (555) 000-0000'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make(__('Address Details'))
                            ->schema([
                                Forms\Components\TextInput::make('street')
                                    ->label(__('Street Address'))
                                    ->maxLength(255)
                                    ->placeholder(__('Enter street address')),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')
                                            ->label(__('City'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter city')),
                                        Forms\Components\TextInput::make('state')
                                            ->label(__('State'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter state/province')),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('postal_code')
                                            ->label(__('Postal/ZIP Code'))
                                            ->maxLength(20)
                                            ->placeholder(__('Enter postal code')),
                                        Forms\Components\TextInput::make('country')
                                            ->label(__('Country'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter country')),
                                    ]),
                            ]),

                        Forms\Components\Section::make(__('Additional Details'))
                            ->schema([
                                Forms\Components\Textarea::make('details')
                                    ->label(__('Additional Information'))
                                    ->maxLength(500)
                                    ->placeholder(__('Enter any additional delivery instructions or details'))
                                    ->rows(3),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->label(__('Latitude'))
                                            ->numeric()
                                            ->rules(['numeric', 'min:-90', 'max:90'])
                                            ->placeholder(__('Enter latitude')),
                                        Forms\Components\TextInput::make('longitude')
                                            ->label(__('Longitude'))
                                            ->numeric()
                                            ->rules(['numeric', 'min:-180', 'max:180'])
                                            ->placeholder(__('Enter longitude')),
                                    ]),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),


                Forms\Components\Section::make(__('Billing Address'))
                    ->relationship('billingAddress')
                    ->schema([
                        Forms\Components\Hidden::make('address_type_id')
                            ->default(2), // Using numeric value 2 for billing address type
                        Forms\Components\Section::make(__('Contact Information'))
                            ->schema([
                                Forms\Components\TextInput::make('contact_person_name')
                                    ->label(__('Contact Name'))
                                    ->maxLength(255)
                                    ->placeholder(__('Enter contact person name')),
                                Forms\Components\TextInput::make('contact_person_phone')
                                    ->label(__('Contact Phone'))
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(20)
                                    ->placeholder('+1 (555) 000-0000'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make(__('Address Details'))
                            ->schema([
                                Forms\Components\TextInput::make('street')
                                    ->label(__('Street Address'))
                                    ->maxLength(255)
                                    ->placeholder(__('Enter street address')),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')
                                            ->label(__('City'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter city')),
                                        Forms\Components\TextInput::make('state')
                                            ->label(__('State'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter state/province')),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('postal_code')
                                            ->label(__('Postal/ZIP Code'))
                                            ->maxLength(20)
                                            ->placeholder(__('Enter postal code')),
                                        Forms\Components\TextInput::make('country')
                                            ->label(__('Country'))
                                            ->maxLength(255)
                                            ->placeholder(__('Enter country')),
                                    ]),
                            ]),

                        Forms\Components\Section::make(__('Additional Details'))
                            ->schema([
                                Forms\Components\Textarea::make('details')
                                    ->label(__('Additional Information'))
                                    ->maxLength(500)
                                    ->placeholder(__('Enter any additional billing information'))
                                    ->rows(3),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->label(__('Latitude'))
                                            ->numeric()
                                            ->rules(['numeric', 'min:-90', 'max:90'])
                                            ->placeholder(__('Enter latitude')),
                                        Forms\Components\TextInput::make('longitude')
                                            ->label(__('Longitude'))
                                            ->numeric()
                                            ->rules(['numeric', 'min:-180', 'max:180'])
                                            ->placeholder(__('Enter longitude')),
                                    ]),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible()
                    ->collapsed(),


                Forms\Components\Section::make(__('Meta Information'))
                    ->schema([
                        Forms\Components\KeyValue::make('meta')
                            ->label(__('Additional Metadata'))
                            ->keyLabel(__('Key'))
                            ->valueLabel(__('Value'))
                            ->addButtonLabel(__('Add Item'))
                            ->keyPlaceholder(__('Enter key'))
                            ->valuePlaceholder(__('Enter value'))
                            ->columnSpan(2),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->label(__('Customer'))
                    ->formatStateUsing(fn($record) => $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : __('N/A'))
                    ->searchable(['customers.first_name', 'customers.last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('paymentMethod.name_en')
                    ->label(__('Payment Method'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('vat')
                    ->label(__('VAT'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('other_taxes')
                    ->label(__('Other Taxes'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->label(__('Discount'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label(__('Total'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_paid')
                    ->label(__('Amount Paid'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name_en')
                    ->label(__('Order Status'))
                    ->badge()
                    ->color(fn(Order $record): string => match ($record->status->name_en ?? '') {
                        'Pending' => 'warning',
                        'Processing' => 'info',
                        'Shipped' => 'primary',
                        'Delivered' => 'success',
                        'Cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_status_id')
                    ->relationship('status', 'name_en')
                    ->label(__('Order Status'))
                    ->preload()
                    ->searchable(),
                Tables\Filters\SelectFilter::make('payment_method_id')
                    ->relationship('paymentMethod', 'name_en')
                    ->label(__('Payment Method'))
                    ->preload()
                    ->searchable(),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('Order Date From')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('Order Date Until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(function (Order $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->customer->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(function (Order $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->customer->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Order $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->customer->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\Action::make('printInvoice')
                    ->label(__('Print Invoice'))
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('order.invoice.show', $record))
                    ->extraAttributes([
                        'onclick' => "event.preventDefault(); openPrintPreview(this.href)"
                    ])
                    ->visible(function (Order $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->customer->point_of_sale_id === $user->point_of_sale_id;
                    }),
            ])
            ->actionsColumnLabel(__('Actions'))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(function () {
                            $user = Filament::auth()->user();
                            return !$user->point_of_sale_id;
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // Notes relation removed until NotesRelationManager is created
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Order');
    }

    // Get plural label function
    public static function getPluralModelLabel(): string
    {
        return __('Orders');
    }

    // Navigation group function
    public static function getNavigationGroup(): string
    {
        return __('Sales');
    }

    private static function calculateOrderTotals(Forms\Set $set, Forms\Get $get)
    {
        // Get items from state
        $items = $get('../../items') ?? [];
        $subtotal = 0;
        $vat = 0;
        $otherTaxes = 0;
        $totalDiscount = 0;
        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $vatAmount = floatval($item['vat_amount'] ?? 0);
            $otherTaxesAmount = floatval($item['other_taxes_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);

            $subtotal += $unitPrice * $quantity;
            $vat += $vatAmount * $quantity;
            $otherTaxes += $otherTaxesAmount * $quantity;
            $totalDiscount += $discountAmount;
        }

        // Use the parent form context to set the order total values
        $set('../../subtotal', number_format($subtotal, 2, '.', ''));
        $set('../../vat', number_format($vat, 2, '.', ''));
        $set('../../other_taxes', number_format($otherTaxes, 2, '.', ''));
        $set('../../discount', number_format($totalDiscount, 2, '.', ''));
        $total = $subtotal + $vat + $otherTaxes - $totalDiscount;
        $set('../../total', number_format($total, 2, '.', ''));

        // Update balance left
        $amountPaid = floatval($get('../../amount_paid') ?? 0);
        $balanceLeft = $total - $amountPaid;
        $set('../../balance_left', number_format($balanceLeft, 2, '.', ''));
    }

    private static function calculateOrderTotalsOnRepeaterUpdate(Forms\Set $set, Forms\Get $get)
    {
        $items = $get('items') ?? [];
        $subtotal = 0;
        $vat = 0;
        $otherTaxes = 0;
        $totalDiscount = 0;
        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $vatAmount = floatval($item['vat_amount'] ?? 0);
            $otherTaxesAmount = floatval($item['other_taxes_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);

            $subtotal += $unitPrice * $quantity;
            $vat += $vatAmount * $quantity;
            $otherTaxes += $otherTaxesAmount * $quantity;
            $totalDiscount += $discountAmount;
        }

        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('vat', number_format($vat, 2, '.', ''));
        $set('other_taxes', number_format($otherTaxes, 2, '.', ''));
        $set('discount', number_format($totalDiscount, 2, '.', ''));
        $set('vat', number_format($vat, 2, '.', ''));
        $set('other_taxes', number_format($otherTaxes, 2, '.', ''));
        $set('discount', number_format($totalDiscount, 2, '.', ''));
        $total = $subtotal + $vat + $otherTaxes - $totalDiscount;
        $set('total', number_format($total, 2, '.', ''));

        // Update balance left
        $amountPaid = floatval($get('amount_paid') ?? 0);
        $balanceLeft = $total - $amountPaid;
        $set('balance_left', number_format($balanceLeft, 2, '.', ''));
    }

    private static function calculateSalePrice(Forms\Set $set, Forms\Get $get): void
    {
        $price = floatval($get('price') ?? 0);
        $selectedTaxIds = $get('taxes');

        if (empty($selectedTaxIds) || $price <= 0) {
            $set('sale_price', $price);
            return;
        }

        // Get tax details from database
        $taxes = \App\Models\Tax::whereIn('id', $selectedTaxIds)->get();

        $totalTaxAmount = 0;
        foreach ($taxes as $tax) {
            if ($tax->type === 'percentage') {
                // Calculate percentage of the price
                $taxAmount = $price * ($tax->amount / 100);
            } else {
                // Fixed amount
                $taxAmount = $tax->amount;
            }
            $totalTaxAmount += $taxAmount;
        }

        $salePrice = $price + $totalTaxAmount;
        $set('sale_price', round($salePrice, 2));
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        $user = Filament::auth()->user();
        if ($user->point_of_sale_id) {
            return $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        return $query;
    }

    public static function canDelete(Model $record): bool
    {
        $user = Filament::auth()->user();
        return $user->point_of_sale_id === null || $record->point_of_sale_id === $user->point_of_sale_id;
    }

    public static function canEdit(Model $record): bool
    {
        $user = Filament::auth()->user();
        return $user->point_of_sale_id === null || $record->point_of_sale_id === $user->point_of_sale_id;
    }

    public static function canView(Model $record): bool
    {
        $user = Filament::auth()->user();
        return $user->point_of_sale_id === null || $record->point_of_sale_id === $user->point_of_sale_id;
    }

    public static function canCreate(): bool
    {
        return true;
    }

    public static function canAccess(): bool
    {
        return true;
    }
}
