<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Hidden;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Setting;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    public static function form(Form $form): Form
    {
        $locals = LaravelLocalization::getSupportedLocales();

        return $form
            ->columns([
                'default' => 1,
                'sm' => 5,
                'lg' => 5,
            ])
            ->schema([
                Section::make(__('Product information'))
                    ->columnSpan([
                        'default' => 1,
                        'sm' => 3,
                        'lg' => 3,
                    ])
                    ->schema([
                        ...collect($locals)->flatMap(fn($properties, $locale) => [
                            TextInput::make("name_{$locale}")
                                ->label(__('Name') . " ({$properties['native']})")
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                    if ($operation !== 'create') {
                                        return;
                                    }

                                    $set("slug", Str::slug($state));
                                }),

                            Textarea::make("description_{$locale}")
                                ->label(__('Description') . " ({$properties['native']})")
                                ->maxLength(65535)
                                ->nullable(),
                        ])->toArray(),

                        TextInput::make('slug')
                            ->label(__('Slug'))
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        TextInput::make('sku')
                            ->label(__('SKU'))
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('code')
                            ->label(__('Code'))
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),

                        Select::make('company_id')
                            ->label(__('Company'))
                            ->options(function () {
                                $user = Filament::auth()->user();
                                if ($user && $user->company_id) {
                                    return \App\Models\Company::where('id', $user->company_id)->pluck('legal_name', 'id');
                                }
                                return \App\Models\Company::where('is_active', true)->pluck('legal_name', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                if ($user && $user->company_id) {
                                    return $user->company_id;
                                }
                                return null;
                            })
                            ->disabled(function () {
                                $user = Filament::auth()->user();
                                return $user && $user->company_id;
                            })
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                $set('point_of_sale_id', null);
                            }),

                        Forms\Components\Select::make('point_of_sale_id')
                            ->label(__('Point of Sale'))
                            ->required()
                            ->options(function (Forms\Get $get) {
                                $companyId = $get('company_id');
                                if (!$companyId) {
                                    $user = Filament::auth()->user();
                                    if ($user && $user->point_of_sale_id) {
                                        $pointOfSale = \App\Models\PointOfSale::find($user->point_of_sale_id);
                                        if ($pointOfSale) {
                                            return \App\Models\PointOfSale::where('id', $user->point_of_sale_id)
                                                ->pluck('name_en', 'id');
                                        }
                                    }
                                    return [];
                                }

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
                            ->dehydrated(true)
                            ->searchable(),
                    ]),

                Section::make(__('Pricing & Media'))
                    ->columnSpan([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 2,
                    ])
                    ->schema([
                        FileUpload::make('image_url')
                            ->label(__('Product Image'))
                            ->image()
                            ->disk('public')
                            ->directory('products')
                            ->imageEditor()
                            ->maxSize(5120) // 5MB
                            ->downloadable()
                            ->openable()
                            ->imagePreviewHeight('250')
                            ->panelAspectRatio('2:1')
                            ->panelLayout('integrated')
                            ->visibility('public')
                            ->storeFileNamesIn('original_filename')
                            ->preserveFilenames(),

                            Select::make('product_category_id')
                            ->label(__('Product Category'))
                            ->options(function (Forms\Get $get) {
                                // Get selected company and point of sale
                                $companyId = $get('company_id');
                                $posId = $get('point_of_sale_id');

                                if (!$companyId) {
                                    return [];
                                }

                                $query = ProductCategory::query();

                                // If point of sale is selected, show only categories from that POS
                                if ($posId) {
                                    $query->where('point_of_sale_id', $posId);
                                }
                                // Otherwise show all categories from the company
                                else {
                                    $query->where('company_id', $companyId)
                                          ->where(function ($query) {
                                              $query->whereNull('point_of_sale_id')
                                                    ->orWhereNotNull('point_of_sale_id');
                                          });
                                }

                                $categories = $query->get();

                                // Format the categories with breadcrumbs
                                return $categories->mapWithKeys(function ($category) {
                                    $breadcrumbs = array_reverse($category->buildBreadcrumbs($category->id));
                                    $label = collect($breadcrumbs)
                                    ->pluck('name')
                                        ->join(' > ');

                                    return [$category->id => $label];
                                })->toArray();
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\Section::make(__('English Content'))
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label(__('Name'))
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                $set('slug', Str::slug($state));
                                            }),
                                            Forms\Components\TextInput::make('name_ar')
                                            ->label(__('Name'))
                                            ->required()
                                            ->maxLength(255),
                                    ])
                                    ->collapsible(false)
                                    ->columns(1),

                                Forms\Components\Section::make(__('Category Structure'))
                                    ->description(__('Define how this category fits in your product hierarchy'))
                                    ->schema([
                                        Select::make('company_id')
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

                                        Select::make('point_of_sale_id')
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

                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('URL Slug'))
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-m-link')
                                            ->helperText(__('This will be used in the URL. Use lowercase letters, numbers, and hyphens only.')),
                                    ])
                                    ->columns(1),
                            ])
                            ->createOptionUsing(function (array $data) {
                                return ProductCategory::create([
                                    'name_en' => $data['name_en'],
                                    'name_ar' => $data['name_ar'],
                                    'slug' => $data['slug'],
                                    'company_id' => $data['company_id'],
                                    'point_of_sale_id' => $data['point_of_sale_id'],
                                ])->id;
                            })
                            ->createOptionModalHeading(__('Create new product category')),

                        Select::make('currency_id')
                            ->label(__('Currency'))
                            ->relationship('currency', 'code')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                return Currency::where('code', Setting::get('default_currency') ?? 'SAR')->first()?->id;
                            }),

                        TextInput::make('price')
                            ->label(__('Price'))
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get)),

                        TextInput::make('quantity')
                            ->label(__('Stock Quantity'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->step(1)
                            ->required(),

                        CheckboxList::make('taxes')
                            ->label(__('Taxes'))
                            ->relationship(
                                'taxes',
                                fn() => app()->getLocale() === 'en' ? 'name_en' : 'name_ar'
                            )
                            ->options(function (Forms\Get $get) {
                                $companyId = $get('company_id');
                                if (!$companyId) {
                                    return [];
                                }

                                return \App\Models\Tax::query()
                                    ->where('company_id', $companyId)
                                    ->where('is_active', true)
                                    ->pluck(app()->getLocale() === 'en' ? 'name_en' : 'name_ar', 'id')
                                    ->toArray();
                            })
                            ->live()
                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get))
                            ->helperText(__('Select applicable taxes for this product'))
                            ->columns(),

                        TextInput::make('sale_price')
                            ->label(__('Sale price (with taxes)'))
                            ->numeric()
                            ->disabled()
                            ->dehydrated(true)
                            ->step(0.01),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                $user = Filament::auth()->user();
                if ($user->point_of_sale_id) {
                    return $query->where('point_of_sale_id', $user->point_of_sale_id);
                }
                return $query;
            })
            ->columns([
                Tables\Columns\ImageColumn::make('image_url_path')
                    ->label('')
                    ->disk('public')
                    ->square()
                    ->size(40),

                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label(__('Code'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_' . app()->getLocale())
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('breadcrumbs')
                    ->label(__('Category'))
                    ->state(function (Product $record): string {
                        if (!$record->category) {
                            return '';
                        }
                        $breadcrumbs = array_reverse($record->category->buildBreadcrumbs($record->category->id));
                        return collect($breadcrumbs)
                            ->pluck('name')
                            ->join(' > ');
                    })
                    ->searchable(false)
                    ->wrap(),

                Tables\Columns\TextColumn::make('price')
                    ->label(__('Unit Price'))
                    ->money(fn($record) => $record->currency ? $record->currency->code : 'USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->label(__('Stock'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('taxes_list')
                    ->label(__('Applicable Taxes'))
                    ->state(function (Product $record): string {
                        if ($record->taxes->isEmpty()) {
                            return '-';
                        }
                        return $record->taxes->pluck(app()->getLocale() === 'en' ? 'name_en' : 'name_ar')->join(', ');
                    }),

                Tables\Columns\TextColumn::make('sale_price')
                    ->label(__('Sale Price'))
                    ->money(fn($record) => $record->currency ? $record->currency->code : 'USD')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('product_category_id')
                    ->relationship('category', 'name_' . app()->getLocale())
                    ->label(__('Category'))
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(function (Product $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(function (Product $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Product $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
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
                    Tables\Actions\RestoreBulkAction::make()
                        ->visible(function () {
                            $user = Filament::auth()->user();
                            return !$user->point_of_sale_id;
                        }),
                    Tables\Actions\ForceDeleteBulkAction::make()
                        ->visible(function () {
                            $user = Filament::auth()->user();
                            return !$user->point_of_sale_id;
                        }),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Product');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Products');
    }

    public static function getNavigationGroup(): string
    {
        return __('Manage products');
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // Apply filtering based on user
        $user = Filament::auth()->user();

        // If user has a point_of_sale_id, they can only see products from their POS
        if ($user && $user->point_of_sale_id) {
            $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        // If user has a company_id but no point_of_sale_id, they can see all products from their company
        elseif ($user && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }

        return $query;
    }

    protected static function calculateSalePrice(Forms\Set $set, Forms\Get $get): void
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

    public static function canDelete(Model $record): bool
    {
        $user = Filament::auth()->user();
        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
    }

    public static function canEdit(Model $record): bool
    {
        $user = Filament::auth()->user();
        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
    }

    public static function canView(Model $record): bool
    {
        $user = Filament::auth()->user();
        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
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
