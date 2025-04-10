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

                Forms\Components\Section::make(__('Customer Information'))
                    ->schema([
                        Forms\Components\Select::make('customer_id')
                            ->relationship(
                                name: 'customer',
                                modifyQueryUsing: fn(Builder $query) => $query
                                    ->select(['id', 'first_name', 'last_name'])
                                    ->orderBy('first_name')
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->label(__('Customer'))
                            ->required(),
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
                            ->preload(),
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'legal_name')
                            ->label(__('Company'))
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                return $user && $user->company_id ? $user->company_id : null;
                            }),
                    ])
                    ->columns(3),


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
                //         Forms\Components\TextInput::make('tax')
                //             ->label(__('Tax'))
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
                //                     $tax = (float)($get('tax') ?? 0);
                //                     $component->state($shipping + $subtotal + $tax);
                //                 }
                //             })
                //             ->live()
                //             ->disabled(),
                //     ])
                //     ->columns(2),

                Forms\Components\Section::make(__('Order Items'))
                    ->headerActions([
                        Forms\Components\Actions\Action::make('add_products')
                            ->label(__('Add New Products to Inventory'))
                            ->icon('heroicon-o-plus')
                            ->color('primary')
                            ->url(fn() => route('filament.admin.resources.products.create', [
                                'return_url' => request()->fullUrl(),
                            ])),
                    ])
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->label(__('Items'))
                            ->relationship()
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->relationship('product', 'name_en')
                                            ->label(__('Product'))
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->live()
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
                                                $set('tax_amount', 0);

                                                // Set new values
                                                $set('product_name_en', $product->name_en);
                                                $set('product_name_ar', $product->name_ar);
                                                $set('product_description_en', $product->description_en);
                                                $set('product_description_ar', $product->description_ar);
                                                $set('product_sku', $product->sku);
                                                $set('unit_price', $product->price);

                                                // Calculate taxes
                                                $taxesTotal = 0;
                                                if ($product->taxes->count() > 0) {
                                                    foreach ($product->taxes as $tax) {
                                                        if ($tax->type === 'percentage') {
                                                            // Use floatval to ensure decimal precision
                                                            $taxesTotal += floatval($product->price) * (floatval($tax->amount) / 100);
                                                        } else {
                                                            // Use floatval to ensure decimal precision
                                                            $taxesTotal += floatval($tax->amount);
                                                        }
                                                    }
                                                }
                                                // Preserve decimals with exact precision
                                                $set('tax_amount', number_format($taxesTotal, 2, '.', ''));

                                                // Calculate initial total price
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($product->price);
                                                $taxAmount = floatval($taxesTotal);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $taxAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('quantity')
                                            ->label(__('Quantity'))
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($state ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $taxAmount = floatval($get('tax_amount') ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $taxAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('unit_price')
                                            ->label(__('Unit Price'))
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($state ?? 0);
                                                $taxAmount = floatval($get('tax_amount') ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $taxAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('tax_amount')
                                            ->label(__('VAT/Tax'))
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->step(0.01)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $taxAmount = floatval($state ?? 0);
                                                $discountAmount = floatval($get('discount_amount') ?? 0);
                                                $set('total_price', number_format((($unitPrice + $taxAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('discount_amount')
                                            ->label(__('Discount'))
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->step(0.01)
                                            ->default(0)
                                            ->minValue(0)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                $quantity = floatval($get('quantity') ?? 1);
                                                $unitPrice = floatval($get('unit_price') ?? 0);
                                                $taxAmount = floatval($get('tax_amount') ?? 0);
                                                $discountAmount = floatval($state ?? 0);
                                                $set('total_price', number_format((($unitPrice + $taxAmount) * $quantity) - $discountAmount, 2, '.', ''));

                                                self::calculateOrderTotals($set, $get);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('total_price')
                                            ->label(__('Total Price'))
                                            ->required()
                                            ->numeric()
                                            ->step(0.01)
                                            ->minValue(0)
                                            ->disabled()
                                            ->dehydrated()
                                            ->columnSpan(1),
                                        Forms\Components\Textarea::make('note')
                                            ->rows(1)
                                            ->label(__('Note'))
                                            ->placeholder(__('Add a note for this item'))
                                            ->nullable()
                                            ->dehydrated(true)
                                            ->columnSpan(3),
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
                                Forms\Components\TextInput::make('subtotal')
                                    ->label(__('Subtotal'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->step(0.01)
                                    ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                    ->columnSpan(['md' => 3]),
                                Forms\Components\TextInput::make('tax')
                                    ->label(__('Tax'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->step(0.01)
                                    ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                    ->columnSpan(['md' => 3]),
                                Forms\Components\TextInput::make('total_discount')
                                    ->label(__('Total Discount'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->step(0.01)
                                    ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                    ->columnSpan(['md' => 3]),
                                Forms\Components\TextInput::make('total')
                                    ->label(__('Total'))
                                    ->numeric()
                                    ->disabled()
                                    ->dehydrated()
                                    ->step(0.01)
                                    ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                    ->extraAttributes(['class' => 'text-primary-600 font-bold'])
                                    ->columnSpan(['md' => 3]),
                            ])
                            ->columns(12)
                            ->extraAttributes(['class' => 'border rounded-xl p-4 bg-gray-50 mt-4']),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make(__('Order Details'))
                    ->schema([
                        Forms\Components\Select::make('order_status_id')
                            ->relationship('status', 'name_en')
                            ->label(__('Order Status'))
                            ->required()
                            ->searchable()
                            ->preload(),
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
                        Forms\Components\DateTimePicker::make('estimated_delivery_at')
                            ->label(__('Estimated Delivery At')),
                        Forms\Components\DateTimePicker::make('shipped_at')
                            ->label(__('Shipped At'))
                            ->nullable(),
                        Forms\Components\DateTimePicker::make('delivered_at')
                            ->label(__('Delivered At'))
                            ->nullable(),
                    ])
                    ->columns(3),

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
                Tables\Columns\TextColumn::make('number')
                    ->label(__('Order Number'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.first_name')
                    ->label(__('Customer'))
                    ->formatStateUsing(fn($record) => $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : __('N/A'))
                    ->searchable(['customers.first_name', 'customers.last_name'])
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
                Tables\Columns\TextColumn::make('total')
                    ->label(__('Total'))
                    ->money(fn(Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shippingAddress.city')
                    ->label(__('Shipping City'))
                    ->formatStateUsing(fn($record) => $record->shippingAddress ? "{$record->shippingAddress->city}, {$record->shippingAddress->country}" : __('N/A'))
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('shipped_at')
                    ->label(__('Shipped At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('estimated_delivery_at')
                    ->label(__('Estimated Delivery At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
        $tax = 0;
        $totalDiscount = 0;
        Log::info('Calculating order totals. Items:', $items);
        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $taxAmount = floatval($item['tax_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);

            $subtotal += $unitPrice * $quantity;
            $tax += $taxAmount * $quantity;
            $totalDiscount += $discountAmount;
        }

        // Use the parent form context to set the order total values
        $set('../../subtotal', number_format($subtotal, 2, '.', ''));
        $set('../../tax', number_format($tax, 2, '.', ''));
        $set('../../total_discount', number_format($totalDiscount, 2, '.', ''));
        $set('../../total', number_format($subtotal + $tax - $totalDiscount, 2, '.', ''));
    }

    private static function calculateOrderTotalsOnRepeaterUpdate(Forms\Set $set, Forms\Get $get)
    {
        $items = $get('items') ?? [];
        $subtotal = 0;
        $tax = 0;
        $totalDiscount = 0;
        Log::info('Calculating order totals. Items:', $items);
        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $taxAmount = floatval($item['tax_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);

            $subtotal += $unitPrice * $quantity;
            $tax += $taxAmount * $quantity;
            $totalDiscount += $discountAmount;
        }

        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('tax', number_format($tax, 2, '.', ''));
        $set('total_discount', number_format($totalDiscount, 2, '.', ''));
        $set('total', number_format($subtotal + $tax - $totalDiscount, 2, '.', ''));
    }
}
