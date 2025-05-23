<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductCategoryResource\Pages;
use App\Filament\Admin\Resources\ProductCategoryResource\RelationManagers;
use App\Models\ProductCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Filament\Facades\Filament;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $currentLocale = app()->getLocale();
        $locales = LaravelLocalization::getSupportedLocales();

        return $form
            ->schema([
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
                                'name_' . $currentLocale
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
                            ->helperText(__('This will be used in the URL. Use lowercase letters, numbers, and hyphens only.'))
                            ->hint(fn() => url('/categories/') . '/[slug]'),

                        Forms\Components\Select::make('company_id')
                            ->label(__('Company'))
                            ->relationship('company', 'legal_name')
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
                            ->dehydrated(true)
                            ->live()
                            ->afterStateUpdated(fn(Forms\Set $set) => $set('point_of_sale_id', null)),

                        Forms\Components\Select::make('point_of_sale_id')
                            ->label(__('Point of Sale'))
                            ->options(function (Forms\Get $get) {
                                $companyId = $get('company_id');
                                if (!$companyId) {
                                    // If user has a point_of_sale_id but no company_id is selected yet,
                                    // we need to get the company_id from the user's point of sale
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
                            ->default(function () {
                                $user = Filament::auth()->user();
                                return $user && $user->point_of_sale_id ? $user->point_of_sale_id : null;
                            })
                            ->disabled(function () {
                                $user = Filament::auth()->user();
                                return $user && $user->point_of_sale_id;
                            })
                            ->required()
                            ->dehydrated(true)
                            ->searchable()
                            ->placeholder(__('Select Point of Sale'))
                            ->helperText(__('Optional: Associate this category with a specific point of sale')),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        $currentLocale = app()->getLocale();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make("name_{$currentLocale}")
                    ->label(__('Name'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make("parentCategory.name_{$currentLocale}")
                    ->label(__('Parent category'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('company.legal_name')
                    ->label(__('Company'))
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pointOfSale.name_en')
                    ->label(__('Point of Sale'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('breadcrumbs')
                    ->label(__('Breadcrumbs'))
                    ->state(function (ProductCategory $record): string {
                        $breadcrumbs = array_reverse($record->buildBreadcrumbs($record->id));
                        return collect($breadcrumbs)
                            ->pluck('name')
                            ->join(' > ');
                    })
                    ->searchable(false)
                    ->wrap(),

                Tables\Columns\TextColumn::make('slug')
                    ->label(__('Slug'))
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('Products'))
                    ->counts('products')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('parent_id')
                    ->label(__('Parent category'))
                    ->relationship('parentCategory', "name_{$currentLocale}")
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('company_id')
                    ->label(__('Company'))
                    ->relationship('company', 'legal_name')
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('point_of_sale_id')
                    ->label(__('Point of Sale'))
                    ->relationship('pointOfSale', 'name_en')
                    ->searchable()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'view' => Pages\ViewProductCategory::route('/{record}'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // Apply filtering based on user
        $user = Filament::auth()->user();

        // If user has a point_of_sale_id, they can only see categories from their POS
        if ($user && $user->point_of_sale_id) {
            $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        // If user has a company_id but no point_of_sale_id, they can see all categories from their company
        elseif ($user && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }

        return $query;
    }

    public static function getGlobalSearchResultTitle(Model $record): string
    {
        return $record->{'name_' . app()->getLocale()};
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name_en', 'name_ar', 'description_en', 'description_ar', 'slug'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $parentName = $record->parentCategory
            ? $record->parentCategory->{'name_' . app()->getLocale()}
            : null;

        return [
            'Parent' => $parentName,
            'Slug' => $record->slug,
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Product category');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Product categories');
    }

    public static function getNavigationGroup(): string
    {
        return __('Manage products');
    }
}
