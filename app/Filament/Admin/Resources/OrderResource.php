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
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\DateRangeFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Currency;
use App\Models\Product;
use Filament\Forms\Components\TextInput\Mask;
use App\Models\AddressType;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Order Information'))
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
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->select(['id', 'first_name', 'last_name'])
                                    ->orderBy('first_name')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->label(__('Customer'))
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->relationship(
                                name: 'user',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->select(['id', 'first_name', 'last_name'])
                                    ->orderBy('first_name')
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                            ->label(__('Assigned Staff'))
                            ->searchable(['first_name', 'last_name'])
                            ->preload(),
                        Forms\Components\Select::make('company_id')
                            ->relationship('company', 'legal_name')
                            ->label(__('Company'))
                            ->searchable()
                            ->preload(),
                    ])
                    ->columns(3),

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
                            ->preload(),
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

                Forms\Components\Section::make(__('Financial Details'))
                    ->schema([
                        Forms\Components\TextInput::make('shipping_fee')
                            ->label(__('Shipping Fee'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('subtotal')
                            ->label(__('Subtotal'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('tax')
                            ->label(__('Tax'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('total')
                            ->label(__('Total'))
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                            ->dehydrated()
                            ->afterStateHydrated(function (Forms\Components\TextInput $component, $state, Forms\Get $get) {
                                if (blank($state)) {
                                    $shipping = (float)($get('shipping_fee') ?? 0);
                                    $subtotal = (float)($get('subtotal') ?? 0);
                                    $tax = (float)($get('tax') ?? 0);
                                    $component->state($shipping + $subtotal + $tax);
                                }
                            })
                            ->live()
                            ->disabled(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make(__('Order Items'))
                    ->schema([
                        Forms\Components\Repeater::make('items')

                            ->relationship()
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

                                        $set('product_name_en', $product->name_en);
                                        $set('product_name_ar', $product->name_ar);
                                        $set('product_description_en', $product->description_en);
                                        $set('product_description_ar', $product->description_ar);
                                        $set('product_sku', $product->sku);
                                        $set('unit_price', $product->price);

                                        // Calculate initial total price
                                        $quantity = $get('quantity') ?? 1;
                                        $set('total_price', $product->price * $quantity);
                                    }),
                                Forms\Components\TextInput::make('quantity')
                                    ->label(__('Quantity'))
                                    ->required()
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                        $quantity = (int) ($state ?? 1);
                                        $unitPrice = (float) ($get('unit_price') ?? 0);
                                        $set('total_price', $quantity * $unitPrice);
                                    }),
                                Forms\Components\TextInput::make('unit_price')
                                    ->label(__('Unit Price'))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->live()
                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                        $quantity = (int) ($get('quantity') ?? 1);
                                        $unitPrice = (float) ($state ?? 0);
                                        $set('total_price', $quantity * $unitPrice);
                                    }),
                                Forms\Components\TextInput::make('total_price')
                                    ->label(__('Total Price'))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->disabled()
                                    ->dehydrated(),
                                Forms\Components\Hidden::make('product_name_en')
                                    ->required(),
                                Forms\Components\Hidden::make('product_name_ar')
                                    ->required(),
                                Forms\Components\Hidden::make('product_description_en')
                                    ->required(),
                                Forms\Components\Hidden::make('product_description_ar')
                                    ->nullable(),
                                Forms\Components\Hidden::make('product_sku')
                                    ->nullable(),
                            ])
                            ->defaultItems(1)
                            ->reorderable(false)
                            ->cloneable()
                            ->collapsible()
                            ->itemLabel(function (array $state): ?string {
                                $productName = $state['product_name_en'] ?? null;
                                $quantity = $state['quantity'] ?? 0;
                                $totalPrice = $state['total_price'] ?? 0;

                                if (!$productName) return null;

                                return "{$productName} - {$quantity} " . __('units') . " - \${$totalPrice}";
                            })
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                                'xl' => 4,
                            ]),
                    ])
                    ->collapsible(),

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
                    ->collapsible(),

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
                    ->collapsible(),

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
                    ->formatStateUsing(fn ($record) => $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : __('N/A'))
                    ->searchable(['customers.first_name', 'customers.last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name_en')
                    ->label(__('Order Status'))
                    ->badge()
                    ->color(fn (Order $record): string => match ($record->status->name_en ?? '') {
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
                    ->money(fn (Order $record): string => $record->currency?->code ?? 'USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('shippingAddress.city')
                    ->label(__('Shipping City'))
                    ->formatStateUsing(fn ($record) => $record->shippingAddress ? "{$record->shippingAddress->city}, {$record->shippingAddress->country}" : __('N/A'))
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
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
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
}
