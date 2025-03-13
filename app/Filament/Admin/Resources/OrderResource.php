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
                Forms\Components\Section::make('Customer Information')
                    ->schema([
                        Forms\Components\TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('customer_phone_number')
                            ->tel()
                            ->required()
                            ->maxLength(20),
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
                            ->required()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if ($state) {
                                    $customer = \App\Models\User::find($state);
                                    if ($customer) {
                                        $set('customer_name', "{$customer->first_name} {$customer->last_name}");
                                        $set('customer_email', $customer->email);
                                    }
                                }
                            }),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Order Details')
                    ->schema([
                        Forms\Components\Select::make('order_status_id')
                            ->relationship('status', 'name_en')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('payment_method_id')
                            ->relationship('paymentMethod', 'name_en')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('currency_id')
                            ->relationship('currency', 'code')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\DateTimePicker::make('estimated_delivery_at')
                            ->required(),
                        Forms\Components\DateTimePicker::make('delivered_at')
                            ->nullable(),
                        Forms\Components\DateTimePicker::make('shipped_at')
                            ->nullable(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Financial Details')
                    ->schema([
                        Forms\Components\TextInput::make('shipping_fee')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('subtotal')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('tax')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                        Forms\Components\TextInput::make('total')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn ($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Order Items')
                    ->schema([
                        Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('product_id')
                                    ->relationship('product', 'name_en')
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
                                    ->label('Quantity')
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
                                    ->label('Unit Price')
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
                                    ->label('Total Price')
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
                                    ->required(),
                                Forms\Components\Hidden::make('product_sku')
                                    ->required(),
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
                                
                                return "{$productName} - {$quantity} units - \${$totalPrice}";
                            })
                            ->columns([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                                'xl' => 4,
                            ]),
                    ])
                    ->collapsible(),

                Forms\Components\Section::make('Shipping Address')
                    ->relationship('shippingAddress')
                    ->schema([
                        Forms\Components\Hidden::make('address_type_id')
                            ->default(AddressType::SHIPPING),
                        Forms\Components\Section::make('Contact Information')
                            ->schema([
                                Forms\Components\TextInput::make('contact_person_name')
                                    ->label('Contact Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter contact person name'),
                                Forms\Components\TextInput::make('contact_person_phone')
                                    ->label('Contact Phone')
                                    ->required()
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(20)
                                    ->placeholder('+1 (555) 000-0000'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Address Details')
                            ->schema([
                                Forms\Components\TextInput::make('street')
                                    ->label('Street Address')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter street address'),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter city'),
                                        Forms\Components\TextInput::make('state')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter state/province'),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('postal_code')
                                            ->label('Postal/ZIP Code')
                                            ->required()
                                            ->maxLength(20)
                                            ->placeholder('Enter postal code'),
                                        Forms\Components\TextInput::make('country')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter country'),
                                    ]),
                            ]),

                        Forms\Components\Section::make('Additional Details')
                            ->schema([
                                Forms\Components\Textarea::make('details')
                                    ->label('Additional Information')
                                    ->maxLength(500)
                                    ->placeholder('Enter any additional delivery instructions or details')
                                    ->rows(3),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->numeric()
                                            ->rules(['numeric', 'min:-90', 'max:90'])
                                            ->placeholder('Enter latitude'),
                                        Forms\Components\TextInput::make('longitude')
                                            ->numeric()
                                            ->rules(['numeric', 'min:-180', 'max:180'])
                                            ->placeholder('Enter longitude'),
                                    ]),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),

                Forms\Components\Section::make('Billing Address')
                    ->relationship('billingAddress')
                    ->schema([
                        Forms\Components\Hidden::make('address_type_id')
                            ->default(AddressType::BILLING),
                        Forms\Components\Section::make('Contact Information')
                            ->schema([
                                Forms\Components\TextInput::make('contact_person_name')
                                    ->label('Contact Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter contact person name'),
                                Forms\Components\TextInput::make('contact_person_phone')
                                    ->label('Contact Phone')
                                    ->required()
                                    ->tel()
                                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                                    ->maxLength(20)
                                    ->placeholder('+1 (555) 000-0000'),
                            ])
                            ->columns(2),

                        Forms\Components\Section::make('Address Details')
                            ->schema([
                                Forms\Components\TextInput::make('street')
                                    ->label('Street Address')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Enter street address'),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('city')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter city'),
                                        Forms\Components\TextInput::make('state')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter state/province'),
                                    ]),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('postal_code')
                                            ->label('Postal/ZIP Code')
                                            ->required()
                                            ->maxLength(20)
                                            ->placeholder('Enter postal code'),
                                        Forms\Components\TextInput::make('country')
                                            ->required()
                                            ->maxLength(255)
                                            ->placeholder('Enter country'),
                                    ]),
                            ]),

                        Forms\Components\Section::make('Additional Details')
                            ->schema([
                                Forms\Components\Textarea::make('details')
                                    ->label('Additional Information')
                                    ->maxLength(500)
                                    ->placeholder('Enter any additional billing information')
                                    ->rows(3),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('latitude')
                                            ->numeric()
                                            ->rules(['numeric', 'min:-90', 'max:90'])
                                            ->placeholder('Enter latitude'),
                                        Forms\Components\TextInput::make('longitude')
                                            ->numeric()
                                            ->rules(['numeric', 'min:-180', 'max:180'])
                                            ->placeholder('Enter longitude'),
                                    ]),
                            ]),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status.name_en')
                    ->badge()
                    ->color(fn (Order $record): string => match ($record->status->name_en) {
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
                    ->money(fn (Order $record): string => $record->currency->code)
                    ->sortable(),
                // Add shipping address
                Tables\Columns\TextColumn::make('shippingAddress.street')
                    ->label('Shipping Address')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
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
        return __('E-commerce');
    }
}
