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
use App\Models\PaymentMethod;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;


class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\View::make('filament.scripts.prevent-enter-submission')
                    ->columnSpanFull()
                    ->extraAttributes(['class' => 'hidden']),

                Forms\Components\Section::make()
                    ->label(__('Order Information'))
                    ->schema([
                        Forms\Components\TextInput::make('number')
                            ->label(__('Order Number'))
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder(__('Will be auto-generated'))
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('issue_date')
                            ->label(__('Issue Date'))
                            ->required()
                            ->dehydrated()
                            ->default(now())
                            ->displayFormat('d/m/Y')
                            ->native(false),
                    ])->columns(2),

                Forms\Components\Section::make(__('Point of Sale Information'))
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(__('Company'))
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
                            ->label(__('Point of Sale'))
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
                                modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                                    $user = Filament::auth()->user();
                                    if ($user->point_of_sale_id) {
                                        return $query->where('point_of_sale_id', $user->point_of_sale_id)
                                            ->where('is_active', true);
                                    } else {
                                        if ($get('company_id')) {
                                            if ($get('point_of_sale_id')) {
                                                return $query->where('company_id', $get('company_id'))
                                                    ->where('point_of_sale_id', $get('point_of_sale_id'))
                                                    ->where('is_active', true);
                                            } else {
                                                return $query->where('company_id', $get('company_id'))
                                                    ->where('is_active', true);
                                            }
                                        }
                                        return $query->where('is_active', true);
                                    }
                                }
                            )
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->label(__('Customer'))
                            ->required()
                            ->live()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                if ($user->point_of_sale_id) {
                                    $query = \App\Models\Customer::query()
                                        ->where('is_active', true);

                                    if ($user->point_of_sale_id) {
                                        $query->where('point_of_sale_id', $user->point_of_sale_id);
                                    }
                                    return $query->first()?->id;
                                }
                            })
                            ->afterStateHydrated(function ($state, Forms\Set $set) {
                                if (!$state) return;

                                $customer = \App\Models\Customer::find($state);
                                if ($customer) {
                                    $set('customer_name', "{$customer->first_name} {$customer->last_name}");
                                    $set('customer_email', $customer->email);
                                    $set('customer_phone_number', $customer->phone_number);
                                    $set('company_id', $customer->company_id);
                                    $set('point_of_sale_id', $customer->point_of_sale_id);
                                }
                            })
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    $set('customer_name', null);
                                    $set('customer_email', null);
                                    $set('customer_phone_number', null);
                                    $set('company_id', null);
                                    $set('point_of_sale_id', null);
                                    return;
                                }

                                $customer = \App\Models\Customer::find($state);
                                if ($customer) {
                                    $set('customer_name', "{$customer->first_name} {$customer->last_name}");
                                    $set('customer_email', $customer->email);
                                    $set('customer_phone_number', $customer->phone_number);
                                    $set('company_id', $customer->company_id);
                                    $set('point_of_sale_id', $customer->point_of_sale_id);
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
                                                    ->options(function () {
                                                        $user = Filament::auth()->user();

                                                        // If user has company_id, only show that company
                                                        if ($user && $user->company_id) {
                                                            return \App\Models\Company::where('id', $user->company_id)->pluck('legal_name', 'id');
                                                        }

                                                        // If user has point_of_sale_id but no company_id, get company from point of sale
                                                        if ($user && $user->point_of_sale_id) {
                                                            $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                            if ($pointOfSale && $pointOfSale->company_id) {
                                                                return \App\Models\Company::where('id', $pointOfSale->company_id)->pluck('legal_name', 'id');
                                                            }
                                                        }

                                                        // Otherwise show all companies
                                                        return \App\Models\Company::pluck('legal_name', 'id');
                                                    })
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->default(function () {
                                                        $user = Filament::auth()->user();

                                                        // If user has company_id, use it
                                                        if ($user && $user->company_id) {
                                                            return $user->company_id;
                                                        }

                                                        // If user has point_of_sale_id but no company_id, get company from point of sale
                                                        if ($user && $user->point_of_sale_id) {
                                                            $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                            if ($pointOfSale) {
                                                                return $pointOfSale->company_id;
                                                            }
                                                        }

                                                        return null;
                                                    })
                                                    ->disabled(function () {
                                                        $user = Filament::auth()->user();
                                                        // Make disabled if user has company_id or point_of_sale_id
                                                        return ($user && $user->company_id) || ($user && $user->point_of_sale_id);
                                                    })
                                                    ->dehydrated(true) // Ensure the value is submitted when disabled
                                                    ->live()
                                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                        $set('point_of_sale_id', null);
                                                    }),

                                                Forms\Components\Select::make('point_of_sale_id')
                                                    ->label(__('Point of Sale'))
                                                    ->options(function (Forms\Get $get) {
                                                        $companyId = $get('company_id');
                                                        $user = Filament::auth()->user();

                                                        // If user has point_of_sale_id, only show that POS
                                                        if ($user && $user->point_of_sale_id) {
                                                            return \App\Models\PointOfSale::where('id', $user->point_of_sale_id)
                                                                ->pluck('name_en', 'id');
                                                        }

                                                        // If no company selected, return empty
                                                        if (!$companyId) {
                                                            return [];
                                                        }

                                                        // Otherwise show POS from selected company
                                                        return \App\Models\PointOfSale::where('company_id', $companyId)
                                                            ->where('is_active', true)
                                                            ->pluck('name_en', 'id');
                                                    })
                                                    ->required()
                                                    ->default(function () {
                                                        $user = Filament::auth()->user();
                                                        return $user && $user->point_of_sale_id ? $user->point_of_sale_id : null;
                                                    })
                                                    ->disabled(function () {
                                                        $user = Filament::auth()->user();
                                                        return $user && $user->point_of_sale_id;
                                                    })
                                                    ->dehydrated(true) // Ensure the value is submitted when disabled
                                                    ->searchable(),

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
                                    ->when(Filament::auth()->user()->point_of_sale_id, function (Builder $query, $posId) {
                                        return $query->where('point_of_sale_id', $posId);
                                    })
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
                                            ['label' => __('Discount'), 'span' => 2, 'padding' => 20],
                                            ['label' => __('VAT'), 'span' => 1, 'padding' => 10],
                                            ['label' => __('Other Taxes'), 'span' => 1, 'padding' => 10],
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
                                            ->relationship(
                                                name: 'product',
                                                titleAttribute: 'name_en',
                                                modifyQueryUsing: function (Builder $query, Forms\Get $get) {
                                                    $user = Filament::auth()->user();
                                                    // Get all items currently in the repeater
                                                    $items = $get('../../items') ?? [];

                                                    // Extract product IDs that are already selected in other items
                                                    $selectedProductIds = [];
                                                    $currentItemKey = $get('../../items')
                                                        ? array_search($get('..'), $get('../../items'))
                                                        : null;

                                                    foreach ($items as $key => $item) {
                                                        // Skip current item to allow keeping its current product
                                                        if ($key === $currentItemKey) {
                                                            continue;
                                                        }

                                                        if (!empty($item['product_id'])) {
                                                            $selectedProductIds[] = $item['product_id'];
                                                        }
                                                    }

                                                    // Exclude already selected products
                                                    if (!empty($selectedProductIds)) {
                                                        $query->whereNotIn('id', $selectedProductIds);
                                                    }


                                                    if ($user->point_of_sale_id) {
                                                        return $query->where('point_of_sale_id', $user->point_of_sale_id);
                                                    } else {
                                                        // Access point_of_sale_id from the parent form state
                                                        $pointOfSaleId = $get('../../point_of_sale_id');
                                                        return $query->where('point_of_sale_id', $pointOfSaleId);
                                                    }

                                                    return $query;
                                                }
                                            )
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
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
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
                                                            ->preload()
                                                            ->createOptionForm([
                                                                Forms\Components\TextInput::make('name_en')
                                                                    ->label(__('Name (English)'))
                                                                    ->required()
                                                                    ->live(onBlur: true)
                                                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                                        $set('slug', Str::slug($state));
                                                                    }),
                                                                Forms\Components\TextInput::make('name_ar')
                                                                    ->label(__('Name (Arabic)'))
                                                                    ->required(),
                                                                Forms\Components\TextInput::make('slug')
                                                                    ->label(__('Slug'))
                                                                    ->required()
                                                                    ->unique('product_categories', 'slug')
                                                                    ->maxLength(255),
                                                                Forms\Components\Select::make('company_id')
                                                                    ->label(__('Company'))
                                                                    ->options(function () {
                                                                        $user = Filament::auth()->user();

                                                                        // If user has company_id, only show that company
                                                                        if ($user && $user->company_id) {
                                                                            return \App\Models\Company::where('id', $user->company_id)->pluck('legal_name', 'id');
                                                                        }

                                                                        // If user has point_of_sale_id but no company_id, get company from point of sale
                                                                        if ($user && $user->point_of_sale_id) {
                                                                            $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                                            if ($pointOfSale && $pointOfSale->company_id) {
                                                                                return \App\Models\Company::where('id', $pointOfSale->company_id)->pluck('legal_name', 'id');
                                                                            }
                                                                        }

                                                                        // Otherwise show all companies
                                                                        return \App\Models\Company::pluck('legal_name', 'id');
                                                                    })
                                                                    ->required()
                                                                    ->searchable()
                                                                    ->preload()
                                                                    ->default(function () {
                                                                        $user = Filament::auth()->user();

                                                                        // If user has company_id, use it
                                                                        if ($user && $user->company_id) {
                                                                            return $user->company_id;
                                                                        }

                                                                        // If user has point_of_sale_id but no company_id, get company from point of sale
                                                                        if ($user && $user->point_of_sale_id) {
                                                                            $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                                            if ($pointOfSale) {
                                                                                return $pointOfSale->company_id;
                                                                            }
                                                                        }

                                                                        return null;
                                                                    })
                                                                    ->disabled(function () {
                                                                        $user = Filament::auth()->user();
                                                                        // Make disabled if user has company_id or point_of_sale_id
                                                                        return ($user && $user->company_id) || ($user && $user->point_of_sale_id);
                                                                    })
                                                                    ->dehydrated(true) // Ensure the value is submitted when disabled
                                                                    ->live()
                                                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                                        $set('point_of_sale_id', null);
                                                                    }),

                                                                Forms\Components\Select::make('point_of_sale_id')
                                                                    ->label(__('Point of Sale'))
                                                                    ->options(function (Forms\Get $get) {
                                                                        $companyId = $get('company_id');
                                                                        $user = Filament::auth()->user();

                                                                        // If user has point_of_sale_id, only show that POS
                                                                        if ($user && $user->point_of_sale_id) {
                                                                            return \App\Models\PointOfSale::where('id', $user->point_of_sale_id)
                                                                                ->pluck('name_en', 'id');
                                                                        }

                                                                        // If no company selected, return empty
                                                                        if (!$companyId) {
                                                                            return [];
                                                                        }

                                                                        // Otherwise show POS from selected company
                                                                        return \App\Models\PointOfSale::where('company_id', $companyId)
                                                                            ->where('is_active', true)
                                                                            ->pluck('name_en', 'id');
                                                                    })
                                                                    ->required()
                                                                    ->default(function () {
                                                                        $user = Filament::auth()->user();
                                                                        return $user && $user->point_of_sale_id ? $user->point_of_sale_id : null;
                                                                    })
                                                                    ->disabled(function () {
                                                                        $user = Filament::auth()->user();
                                                                        return $user && $user->point_of_sale_id;
                                                                    })
                                                                    ->dehydrated(true) // Ensure the value is submitted when disabled
                                                                    ->searchable(),
                                                            ])
                                                            ->createOptionAction(
                                                                fn (Forms\Components\Actions\Action $action) => $action
                                                                    ->modalHeading(__('Create Product Category'))
                                                                    ->modalSubmitActionLabel(__('Create'))
                                                                    ->modalWidth('md')
                                                                    ->closeModalByClickingAway(false)
                                                            ),

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
                                                            ->live(onBlur: true)
                                                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get)),

                                                        Forms\Components\TextInput::make('quantity')
                                                            ->label(__('Quantity'))
                                                            ->numeric()
                                                            ->required()
                                                            ->minValue(0)
                                                            ->default(0),

                                                        Forms\Components\Select::make('company_id')
                                                            ->label(__('Company'))
                                                            ->options(function () {
                                                                $user = Filament::auth()->user();

                                                                // If user has company_id, only show that company
                                                                if ($user && $user->company_id) {
                                                                    return \App\Models\Company::where('id', $user->company_id)->pluck('legal_name', 'id');
                                                                }

                                                                // If user has point_of_sale_id but no company_id, get company from point of sale
                                                                if ($user && $user->point_of_sale_id) {
                                                                    $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                                    if ($pointOfSale && $pointOfSale->company_id) {
                                                                        return \App\Models\Company::where('id', $pointOfSale->company_id)->pluck('legal_name', 'id');
                                                                    }
                                                                }

                                                                // Otherwise show all companies
                                                                return \App\Models\Company::pluck('legal_name', 'id');
                                                            })
                                                            ->required()
                                                            ->searchable()
                                                            ->preload()
                                                            ->default(function () {
                                                                $user = Filament::auth()->user();

                                                                // If user has company_id, use it
                                                                if ($user && $user->company_id) {
                                                                    return $user->company_id;
                                                                }

                                                                // If user has point_of_sale_id but no company_id, get company from point of sale
                                                                if ($user && $user->point_of_sale_id) {
                                                                    $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                                    if ($pointOfSale) {
                                                                        return $pointOfSale->company_id;
                                                                    }
                                                                }

                                                                return null;
                                                            })
                                                            ->disabled(function () {
                                                                $user = Filament::auth()->user();
                                                                // Make disabled if user has company_id or point_of_sale_id
                                                                return ($user && $user->company_id) || ($user && $user->point_of_sale_id);
                                                            })
                                                            ->dehydrated(true) // Ensure the value is submitted when disabled
                                                            ->live()
                                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                                $set('point_of_sale_id', null);
                                                            }),

                                                        Forms\Components\Select::make('point_of_sale_id')
                                                            ->label(__('Point of Sale'))
                                                            ->options(function (Forms\Get $get) {
                                                                $companyId = $get('company_id');
                                                                $user = Filament::auth()->user();

                                                                // If user has point_of_sale_id, only show that POS
                                                                if ($user && $user->point_of_sale_id) {
                                                                    return \App\Models\PointOfSale::where('id', $user->point_of_sale_id)
                                                                        ->pluck('name_en', 'id');
                                                                }

                                                                // If no company selected, return empty
                                                                if (!$companyId) {
                                                                    return [];
                                                                }

                                                                // Otherwise show POS from selected company
                                                                return \App\Models\PointOfSale::where('company_id', $companyId)
                                                                    ->where('is_active', true)
                                                                    ->pluck('name_en', 'id');
                                                            })
                                                            ->required()
                                                            ->default(function () {
                                                                $user = Filament::auth()->user();
                                                                return $user && $user->point_of_sale_id ? $user->point_of_sale_id : null;
                                                            })
                                                            ->disabled(function () {
                                                                $user = Filament::auth()->user();
                                                                return $user && $user->point_of_sale_id;
                                                            })
                                                            ->dehydrated(true) // Ensure the value is submitted when disabled
                                                            ->searchable(),

                                                        Forms\Components\CheckboxList::make('taxes')
                                                            ->label(__('Taxes'))
                                                            ->relationship(
                                                                'taxes',
                                                                fn() => app()->getLocale() === 'en' ? 'name_en' : 'name_ar'
                                                            )
                                                            ->options(function (Forms\Get $get) {
                                                                $user = Filament::auth()->user();
                                                                $companyId = null;

                                                                // If user has point_of_sale_id, get company from POS
                                                                if ($user && $user->point_of_sale_id) {
                                                                    $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                                                    if ($pointOfSale) {
                                                                        $companyId = $pointOfSale->company_id;
                                                                    }
                                                                }
                                                                // If user has company_id, use it directly
                                                                elseif ($user && $user->company_id) {
                                                                    $companyId = $user->company_id;
                                                                }
                                                                // Otherwise use the selected company from the form
                                                                else {
                                                                    $companyId = $get('company_id');
                                                                }

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

                                                // Initial tax rates - will be recalculated after discount
                                                $vatRate = $product->getVatAmount() / $product->price;
                                                $otherTaxesRate = $product->getOtherTaxesAmount() / $product->price;

                                                // Store the rates for later use
                                                $set('vat_rate', $vatRate);
                                                $set('other_taxes_rate', $otherTaxesRate);

                                                // Calculate item values and update the form
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(2),
                                        Forms\Components\TextInput::make('quantity')
                                            ->label(__('Quantity'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
                                            ->default(1)
                                            // ->maxValue(function (Forms\Get $get) {
                                            //     $productId = $get('product_id');
                                            //     if (!$productId) return null;

                                            //     $product = \App\Models\Product::find($productId);
                                            //     return $product ? $product->quantity : null;
                                            // })
                                            // ->helperText(function (Forms\Get $get) {
                                            //     $productId = $get('product_id');
                                            //     if (!$productId) return null;

                                            //     $product = \App\Models\Product::find($productId);
                                            //     return $product ? __('Stock remaining: :quantity', ['quantity' => $product->quantity]) : null;
                                            // })
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(1),
                                        Forms\Components\TextInput::make('unit_price')
                                            ->label(__('Unit Price'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
                                            ->minValue(0)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('discount_amount')
                                            ->label(__('Discount'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->default(0)
                                            ->minValue(0)
                                            ->live(onBlur: true)
                                            ->prefix(fn(Forms\Get $get) => $get('discount_type') === 'percentage' ? '%' : Setting::get('default_currency') ?? 'SAR')
                                            ->suffixAction(
                                                Forms\Components\Actions\Action::make('changeDiscountType')
                                                    ->icon('heroicon-o-cog')
                                                    ->tooltip(fn(Forms\Get $get) => $get('discount_type') === 'fixed'
                                                        ? __('Switch to percentage discount (%)')
                                                        : __('Switch to fixed amount discount ($)'))
                                                    ->action(function (Forms\Set $set, Forms\Get $get) {
                                                        // Toggle between fixed and percentage
                                                        $currentType = $get('discount_type');
                                                        $newType = $currentType === 'fixed' ? 'percentage' : 'fixed';
                                                        $set('discount_type', $newType);

                                                        // Explicitly trigger calculation
                                                        self::calculateOrderItemValues($get, $set);
                                                    })
                                            )
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(2),
                                        Forms\Components\Hidden::make('discount_type')
                                            ->default('fixed')
                                            ->dehydrated(true)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                                self::calculateOrderItemValues($get, $set);
                                            }),

                                        Forms\Components\TextInput::make('vat_amount')
                                            ->label(__('VAT'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                // Mark as manually edited
                                                $set('vat_amount_is_manual', true);
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('other_taxes_amount')
                                            ->label(__('Other Taxes'))
                                            ->hiddenLabel()
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->default(0)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                // Mark as manually edited
                                                $set('other_taxes_amount_is_manual', true);
                                                self::calculateOrderItemValues($get, $set);
                                            })
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('total_price')
                                            ->label(__('Total Price'))
                                            ->hiddenLabel()
                                            ->required()
                                            ->numeric()
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
                                    ->columns(11),
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
                                Forms\Components\Hidden::make('vat_rate')
                                    ->nullable(),
                                Forms\Components\Hidden::make('other_taxes_rate')
                                    ->nullable(),
                                Forms\Components\Hidden::make('vat_amount_is_manual')
                                    ->default(false),
                                Forms\Components\Hidden::make('other_taxes_amount_is_manual')
                                    ->default(false),
                            ])
                            ->defaultItems(1)
                            ->reorderable(false)
                            // ->cloneable()
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
                                            ->default(fn() => PaymentMethod::where('name_en', Setting::get('default_payment_methode'))->first()?->id)
                                            ->preload(),
                                        Forms\Components\Select::make('currency_id')
                                            ->relationship('currency', 'code')
                                            ->label(__('Currency'))
                                            ->required()
                                            ->default(function () {
                                                return Currency::where('code', Setting::get('default_currency'))->first()?->id;
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->default(fn() => Currency::where('code', 'SAR')->first()?->id),
                                        Forms\Components\TextInput::make('amount_paid')
                                            ->label(__('Amount Paid'))
                                            ->numeric()
                                            ->required()
                                            ->minValue(0)
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
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                            ->extraAttributes(['class' => 'text-danger-600 font-bold']),
                                    ])
                                    ->columnSpan(['md' => 6])
                                    ->columns(1),

                                // Right Column
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Hidden::make('products_discount')
                                            ->default(0)
                                            ->dehydrated(true),
                                        Forms\Components\Hidden::make('subtotal')
                                            ->default(0)
                                            ->dehydrated(true),
                                        Forms\Components\Hidden::make('discount_manually_set')
                                            ->default(false)
                                            ->dehydrated(true),
                                        Forms\Components\Hidden::make('order_discount_type')
                                            ->default('fixed')
                                            ->dehydrated(true),
                                        Forms\Components\TextInput::make('subtotal_after_discount')
                                            ->label(__('Subtotal After Discount'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated(true)
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('discount')
                                            ->label(__('Other Discounts'))
                                            ->numeric()
                                            ->dehydrated(true)
                                            ->default(0)
                                            ->prefix(fn($get) => $get('discount_type') === 'percentage' ? '%' : ($get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''))
                                            ->suffixAction(
                                                Forms\Components\Actions\Action::make('changeOtherDiscountType')
                                                    ->icon('heroicon-o-cog')
                                                    ->tooltip(fn(Forms\Get $get) => $get('discount_type') === 'fixed'
                                                        ? __('Switch to percentage discount (%)')
                                                        : __('Switch to fixed amount discount ($)'))
                                                    ->action(function (Forms\Set $set, Forms\Get $get) {
                                                        // Toggle between fixed and percentage
                                                        $currentType = $get('discount_type');
                                                        $newType = $currentType === 'fixed' ? 'percentage' : 'fixed';
                                                        $set('discount_type', $newType);

                                                        // Recalculate totals
                                                        self::recalculateOrderTotals($set, $get);
                                                    })
                                            )
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                self::recalculateOrderTotals($set, $get);
                                            }),
                                        Forms\Components\Hidden::make('discount_type')
                                            ->default('fixed')
                                            ->dehydrated(true)
                                            ->live()
                                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set) {
                                                self::recalculateOrderTotals($set, $get);
                                            }),
                                        Forms\Components\Hidden::make('subtotal_after_other_discount')
                                            ->default(0)
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('vat')
                                            ->label(__('Total VAT Amount'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('other_taxes')
                                            ->label(__('Total Other Taxes'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : '')
                                            ->visible(fn(Forms\Get $get): bool => floatval($get('other_taxes') ?? 0) > 0),
                                        Forms\Components\Hidden::make('other_taxes_hidden')
                                            ->dehydrated(false)
                                            ->visible(fn(Forms\Get $get): bool => floatval($get('other_taxes') ?? 0) == 0),
                                        Forms\Components\TextInput::make('discount_totals')
                                            ->label(__('Discounts Total'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix(fn($get) => $get('currency_id') ? Currency::find($get('currency_id'))?->symbol : ''),
                                        Forms\Components\TextInput::make('total')
                                            ->label(__('Total'))
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
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
                Tables\Columns\TextColumn::make('issue_date')
                    ->label(__('Issue Date'))
                    ->date()
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
                Filter::make('issue_date')
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
                                fn(Builder $query, $date): Builder => $query->whereDate('issue_date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('issue_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('printInvoice')
                    ->label(__('Print Invoice'))
                    ->icon('heroicon-o-printer')
                    ->url(fn($record) => route('order.invoice.show', $record))
                    ->extraAttributes([
                        'onclick' => "event.preventDefault(); openPrintPreview(this.href)"
                    ]),
                Tables\Actions\Action::make('forceDelete')
                    ->label(__('Delete Permanently'))
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading(__('Permanently delete order'))
                    ->modalDescription(__('Are you sure you want to permanently delete this order? This action cannot be undone.'))
                    ->modalSubmitActionLabel(__('Yes, delete permanently'))
                    ->action(fn(Order $record) => $record->forceDelete())
                    ->visible(fn(Order $record): bool => $record->trashed()),
            ])
            ->actionsColumnLabel(__('Actions'))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('forceDelete')
                        ->label(__('Delete Permanently'))
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading(__('Permanently delete selected orders'))
                        ->modalDescription(__('Are you sure you want to permanently delete these orders? This action cannot be undone.'))
                        ->modalSubmitActionLabel(__('Yes, delete permanently'))
                        ->action(fn(Collection $records) => $records->each->forceDelete())
                ]),
            ])
            ->defaultSort('issue_date', 'desc');
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
        $itemVat = 0;  // This is the VAT calculated at item level
        $itemDiscountedSubtotal = 0; // Track the discounted subtotal at item level
        $otherTaxes = 0;
        $itemsDiscount = 0;

        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $vatAmount = floatval($item['vat_amount'] ?? 0);
            $otherTaxesAmount = floatval($item['other_taxes_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);
            $discountType = $item['discount_type'] ?? 'fixed';

            // Calculate discount based on type
            $itemDiscount = $discountAmount;
            if ($discountType === 'percentage') {
                $itemDiscount = ($unitPrice * $quantity) * ($discountAmount / 100);
            }

            // Calculate item's discounted amount
            $itemLineTotal = $unitPrice * $quantity;
            $itemDiscountedTotal = max(0, $itemLineTotal - $itemDiscount);

            // Add to totals
            $subtotal += $itemLineTotal;
            $itemVat += $vatAmount * $quantity;
            $itemDiscountedSubtotal += $itemDiscountedTotal;
            $otherTaxes += $otherTaxesAmount * $quantity;
            $itemsDiscount += $itemDiscount;
        }

        // Always update subtotal, other taxes, and total discount from item calculations
        $set('../../subtotal', number_format($subtotal, 2, '.', ''));
        $set('../../other_taxes', number_format($otherTaxes, 2, '.', ''));
        $set('../../products_discount', number_format($itemsDiscount, 2, '.', ''));

        // Calculate the discounted subtotal
        $discountedSubtotal = max(0, $subtotal - $itemsDiscount);
        $set('../../subtotal_after_discount', number_format($discountedSubtotal, 2, '.', ''));

        // Get current other discount
        $otherDiscountValue = floatval($get('../../discount') ?? 0);
        $otherDiscountType = $get('../../discount_type') ?? 'fixed';
        $otherDiscountAmount = $otherDiscountValue;

        if ($otherDiscountType === 'percentage') {
            $otherDiscountAmount = $discountedSubtotal * ($otherDiscountValue / 100);
        }

        // Calculate the final discounted subtotal
        $finalDiscountedSubtotal = max(0, $discountedSubtotal - $otherDiscountAmount);
        $set('../../subtotal_after_other_discount', number_format($finalDiscountedSubtotal, 2, '.', ''));

        // Calculate total discounts (sum of item discounts and other discounts)
        $totalDiscounts = $itemsDiscount + $otherDiscountAmount;
        $set('../../discount_totals', number_format($totalDiscounts, 2, '.', ''));

        // Calculate the effective VAT rate based on the already-discounted amounts at item level
        $vatRate = $itemDiscountedSubtotal > 0 ? $itemVat / $itemDiscountedSubtotal : 0;

        // Recalculate VAT based on the final discounted subtotal
        $recalculatedVat = $finalDiscountedSubtotal * $vatRate;

        // Update the VAT value
        $set('../../vat', number_format($recalculatedVat, 2, '.', ''));

        // Total is sum of discounted subtotal, recalculated VAT, and other taxes
        $total = $finalDiscountedSubtotal + $recalculatedVat + $otherTaxes;
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
        $itemVat = 0;  // This is the VAT calculated at item level
        $itemDiscountedSubtotal = 0; // Track the discounted subtotal at item level
        $otherTaxes = 0;
        $itemsDiscount = 0;

        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $vatAmount = floatval($item['vat_amount'] ?? 0);
            $otherTaxesAmount = floatval($item['other_taxes_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);
            $discountType = $item['discount_type'] ?? 'fixed';

            // Calculate discount based on type
            $itemDiscount = $discountAmount;
            if ($discountType === 'percentage') {
                $itemDiscount = ($unitPrice * $quantity) * ($discountAmount / 100);
            }

            // Calculate item's discounted amount
            $itemLineTotal = $unitPrice * $quantity;
            $itemDiscountedTotal = max(0, $itemLineTotal - $itemDiscount);

            // Add to totals
            $subtotal += $itemLineTotal;
            $itemVat += $vatAmount * $quantity;
            $itemDiscountedSubtotal += $itemDiscountedTotal;
            $otherTaxes += $otherTaxesAmount * $quantity;
            $itemsDiscount += $itemDiscount;
        }

        // Always update all totals from item calculations
        $set('subtotal', number_format($subtotal, 2, '.', ''));
        $set('other_taxes', number_format($otherTaxes, 2, '.', ''));
        $set('products_discount', number_format($itemsDiscount, 2, '.', ''));

        // Calculate the discounted subtotal
        $discountedSubtotal = max(0, $subtotal - $itemsDiscount);
        $set('subtotal_after_discount', number_format($discountedSubtotal, 2, '.', ''));

        // Get current other discount
        $otherDiscountValue = floatval($get('discount') ?? 0);
        $otherDiscountType = $get('discount_type') ?? 'fixed';

        // Calculate other discount amount
        $otherDiscountAmount = $otherDiscountValue;
        if ($otherDiscountType === 'percentage') {
            $otherDiscountAmount = $discountedSubtotal * ($otherDiscountValue / 100);
        }

        // Calculate subtotal after both discounts
        $finalDiscountedSubtotal = max(0, $discountedSubtotal - $otherDiscountAmount);
        $set('subtotal_after_other_discount', number_format($finalDiscountedSubtotal, 2, '.', ''));

        // Calculate total discounts (sum of item discounts and other discounts)
        $totalDiscounts = $itemsDiscount + $otherDiscountAmount;
        $set('discount_totals', number_format($totalDiscounts, 2, '.', ''));

        // Calculate the effective VAT rate based on actual item data with discounts
        $vatRate = $itemDiscountedSubtotal > 0 ? $itemVat / $itemDiscountedSubtotal : 0;

        // Recalculate VAT based on the final discounted subtotal (after both discounts)
        $recalculatedVat = $finalDiscountedSubtotal * $vatRate;

        // Update the VAT value
        $set('vat', number_format($recalculatedVat, 2, '.', ''));

        // Store the discount type
        $set('discount_type', $get('discount_type'));

        // Calculate total with the new VAT on discounted amount
        $total = $finalDiscountedSubtotal + $recalculatedVat + $otherTaxes;
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

    private static function calculateOrderItemValues(Forms\Get $get, Forms\Set $set): void
    {
        $quantity = floatval($get('quantity') ?? 1);
        $unitPrice = floatval($get('unit_price') ?? 0);
        $vatRate = floatval($get('vat_rate') ?? 0);
        $otherTaxesRate = floatval($get('other_taxes_rate') ?? 0);
        $discountAmount = floatval($get('discount_amount') ?? 0);
        $discountType = $get('discount_type') ?? 'fixed';

        // Check if tax values were manually edited
        $vatIsManual = $get('vat_amount_is_manual') === true;
        $otherTaxesIsManual = $get('other_taxes_amount_is_manual') === true;

        // Calculate discount based on type
        $totalDiscountAmount = $discountAmount;

        if ($discountType === 'percentage') {
            // Convert percentage to actual amount
            $totalDiscountAmount = ($unitPrice * $quantity) * ($discountAmount / 100);
        }

        // Calculate discounted price per unit
        $discountPerUnit = $totalDiscountAmount / $quantity;
        $discountedUnitPrice = max(0, $unitPrice - $discountPerUnit);

        // Only calculate VAT if not manually set
        if (!$vatIsManual) {
            $vatAmount = $discountedUnitPrice * $vatRate;
            $set('vat_amount', number_format($vatAmount, 2, '.', ''));
        }

        // Only calculate Other Taxes if not manually set
        if (!$otherTaxesIsManual) {
            $otherTaxesAmount = $discountedUnitPrice * $otherTaxesRate;
            $set('other_taxes_amount', number_format($otherTaxesAmount, 2, '.', ''));
        }

        // Calculate total using current values (whether calculated or manually entered)
        $vatAmount = floatval($get('vat_amount') ?? 0);
        $otherTaxesAmount = floatval($get('other_taxes_amount') ?? 0);
        $totalPricePerUnit = $discountedUnitPrice + $vatAmount + $otherTaxesAmount;
        $set('total_price', number_format($totalPricePerUnit * $quantity, 2, '.', ''));

        // Reset order discount related fields, but keep other discount settings
        $set('../../order_discount_type', 'fixed');
        $set('../../discount_manually_set', false);
        // Don't reset other discount values
        // $set('../../discount_type', 'fixed');
        // $set('../../discount', 0);

        self::calculateOrderTotals($set, $get);
    }

    private static function recalculateOrderTotals(Forms\Set $set, Forms\Get $get): void
    {
        // This method is now only called when other discount is changed
        // Total discount is always calculated from items

        $subtotal = floatval($get('subtotal') ?? 0);
        $originalVat = floatval($get('vat') ?? 0);
        $otherTaxes = floatval($get('other_taxes') ?? 0);

        // Get total discount from form (sum of item discounts)
        $totalDiscount = floatval($get('products_discount') ?? 0);

        // Calculate the discounted subtotal after item discounts
        $discountedSubtotal = max(0, $subtotal - $totalDiscount);
        $set('subtotal_after_discount', number_format($discountedSubtotal, 2, '.', ''));

        // Get other discount values
        $otherDiscountValue = floatval($get('discount') ?? 0);
        $otherDiscountType = $get('discount_type') ?? 'fixed';

        // Calculate other discount amount
        $otherDiscountAmount = $otherDiscountValue;
        if ($otherDiscountType === 'percentage') {
            $otherDiscountAmount = $discountedSubtotal * ($otherDiscountValue / 100);
        }

        // Calculate subtotal after both discounts
        $finalDiscountedSubtotal = max(0, $discountedSubtotal - $otherDiscountAmount);
        $set('subtotal_after_other_discount', number_format($finalDiscountedSubtotal, 2, '.', ''));

        // Calculate total discounts (sum of item discounts and other discounts)
        $totalDiscounts = $totalDiscount + $otherDiscountAmount;
        $set('discount_totals', number_format($totalDiscounts, 2, '.', ''));

        // We need to recalculate the VAT based on item-level data to ensure accuracy
        // Process all items to get the correct VAT rate
        $items = $get('items') ?? [];
        $itemVat = 0;
        $itemDiscountedSubtotal = 0;

        foreach ($items as $item) {
            $quantity = floatval($item['quantity'] ?? 1);
            $unitPrice = floatval($item['unit_price'] ?? 0);
            $vatAmount = floatval($item['vat_amount'] ?? 0);
            $discountAmount = floatval($item['discount_amount'] ?? 0);
            $discountType = $item['discount_type'] ?? 'fixed';

            // Calculate discount based on type
            $itemDiscount = $discountAmount;
            if ($discountType === 'percentage') {
                $itemDiscount = ($unitPrice * $quantity) * ($discountAmount / 100);
            }

            // Calculate item's discounted amount
            $itemLineTotal = $unitPrice * $quantity;
            $itemDiscountedTotal = max(0, $itemLineTotal - $itemDiscount);

            // Add to tracking totals
            $itemVat += $vatAmount * $quantity;
            $itemDiscountedSubtotal += $itemDiscountedTotal;
        }

        // Calculate the effective VAT rate based on actual item data with discounts
        $vatRate = $itemDiscountedSubtotal > 0 ? $itemVat / $itemDiscountedSubtotal : 0;

        // Recalculate VAT based on the final discounted subtotal (after both discounts)
        $recalculatedVat = $finalDiscountedSubtotal * $vatRate;

        // Update the VAT value
        $set('vat', number_format($recalculatedVat, 2, '.', ''));

        // Store the discount type
        $set('discount_type', $get('discount_type'));

        // Calculate total with the new VAT on discounted amount
        $total = $finalDiscountedSubtotal + $recalculatedVat + $otherTaxes;
        $set('total', number_format($total, 2, '.', ''));

        // Update balance left
        $amountPaid = floatval($get('amount_paid') ?? 0);
        $balanceLeft = $total - $amountPaid;
        $set('balance_left', number_format($balanceLeft, 2, '.', ''));
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // Apply filtering based on user
        $user = Filament::auth()->user();

        // If user has a point_of_sale_id, they can only see orders from their POS
        if ($user && $user->point_of_sale_id) {
            $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        // If user has a company_id but no point_of_sale_id, they can see all orders from their company
        elseif ($user && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }

        return $query;
    }
}
