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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;

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
                        ...collect($locals)->flatMap(fn ($properties, $locale) => [
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

                        TextInput::make('price')
                            ->label(__('Price'))
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01),

                        TextInput::make('sale_price')
                            ->label(__('Sale price'))
                            ->numeric()
                            ->nullable()
                            ->minValue(0)
                            ->step(0.01),

                        Select::make('currency_id')
                            ->label(__('Currency'))
                            ->relationship('currency', 'code')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Select::make('product_category_id')
                            ->label(__('Product Category'))
                            ->relationship(
                                'category',
                                'name_' . app()->getLocale()
                            )
                            ->getOptionLabelFromRecordUsing(fn (ProductCategory $record): string => 
                                collect(array_reverse($record->buildBreadcrumbs($record->id)))
                                    ->pluck('name')
                                    ->join(' > ')
                            )
                            ->required()
                            ->searchable()
                            ->preload(),
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
                    
                Tables\Columns\TextColumn::make('price')
                    ->label(__('Price'))
                    ->money(fn ($record) => $record->currency ? $record->currency->code : 'USD')
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
}
