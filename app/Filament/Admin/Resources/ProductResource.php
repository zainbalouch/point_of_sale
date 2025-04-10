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
                            ->relationship('company', 'legal_name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                $user = Filament::auth()->user();
                                return $user && $user->company_id ? $user->company_id : null;
                            })
                            ->live(),
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
                            ->relationship(
                                'category',
                                'name_' . app()->getLocale()
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn(ProductCategory $record): string =>
                                collect(array_reverse($record->buildBreadcrumbs($record->id)))
                                    ->pluck('name')
                                    ->join(' > ')
                            )
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
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) {
                                                if ($operation !== 'create') {
                                                    return;
                                                }
                                                $set('slug', Str::slug($state));
                                            }),

                                        Forms\Components\RichEditor::make('description_en')
                                            ->label(__('Description'))
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(false)
                                    ->columns(1),

                                Forms\Components\Section::make(__('Arabic Content'))
                                    ->schema([
                                        Forms\Components\TextInput::make('name_ar')
                                            ->label(__('Name'))
                                            ->required()
                                            ->maxLength(255),

                                        Forms\Components\RichEditor::make('description_ar')
                                            ->label(__('Description'))
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->columns(1),

                                Forms\Components\Section::make(__('Category Structure'))
                                    ->description(__('Define how this category fits in your product hierarchy'))
                                    ->schema([
                                        Forms\Components\Select::make('parent_id')
                                            ->label(__('Parent category'))
                                            ->relationship(
                                                'parentCategory',
                                                'name_' . app()->getLocale()
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->nullable()
                                            ->placeholder(__('Select Parent Category'))
                                            ->helperText(__('Choose a parent category to create a hierarchy')),

                                        Forms\Components\TextInput::make('slug')
                                            ->label(__('URL Slug'))
                                            ->required()
                                            ->unique(ignoreRecord: true)
                                            ->maxLength(255)
                                            ->prefixIcon('heroicon-m-link')
                                            ->helperText(__('This will be used in the URL. Use lowercase letters, numbers, and hyphens only.')),

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
                                    ])
                                    ->columns(1),
                            ])
                            ->createOptionModalHeading(__('Create new product category')),

                        Select::make('currency_id')
                            ->label(__('Currency'))
                            ->relationship('currency', 'code')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(function () {
                                return Currency::where('code', 'SAR')->first()?->id;
                            }),

                        TextInput::make('price')
                            ->label(__('Price'))
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01)
                            ->live(debounce: 500)
                            ->afterStateUpdated(fn(Forms\Set $set, Forms\Get $get) => self::calculateSalePrice($set, $get)),

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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->actionsColumnLabel(__('Actions'))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
}
