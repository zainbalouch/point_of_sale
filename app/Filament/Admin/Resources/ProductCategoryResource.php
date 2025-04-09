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
                                return $user && $user->company_id ? $user->company_id : null;
                            }),
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
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
