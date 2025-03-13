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
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Lang;
use Filament\Forms\Components\Card;
use Illuminate\Support\Facades\URL;

class ProductCategoryResource extends Resource
{
    protected static ?string $model = ProductCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        $locals = LaravelLocalization::getSupportedLocales();
        
        return $form->schema([
            Forms\Components\Section::make(__('Category Structure'))
                ->description(__('Define how this category fits in your product hierarchy'))
                ->icon('heroicon-o-rectangle-stack')
                ->collapsible()
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label(__('Parent category'))
                        ->relationship(
                            'parentCategory',
                            'name_' . LaravelLocalization::getCurrentLocale()
                        )
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->placeholder(__('Select Parent Category'))
                        ->helperText(__('Choose a parent category to create a hierarchy'))
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('slug')
                        ->label(__('URL Slug'))
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255)
                        ->prefix(fn () => url('/categories/'))
                        ->helperText(__('This will be used in the URL. Use lowercase letters, numbers, and hyphens only.'))
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make(__('Category Content'))
                ->description(__('Manage the content and descriptions in different languages'))
                ->icon('heroicon-o-language')
                ->collapsible()
                ->schema([
                    Forms\Components\Tabs::make('Locales')
                        ->tabs(
                            collect($locals)->map(fn($properties, $locale) => 
                                Forms\Components\Tabs\Tab::make($properties['native'])
                                    ->icon('heroicon-o-globe-alt')
                                    ->schema([
                                        Forms\Components\TextInput::make("name_{$locale}")
                                            ->label(__('Name'))
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(function (string $operation, $state, Forms\Set $set) use ($locale) {
                                                if ($operation !== 'create') {
                                                    return;
                                                }
                                                
                                                $set('slug', Str::slug($state));
                                            }),

                                        Forms\Components\RichEditor::make("description_{$locale}")
                                            ->label(__('Description'))
                                            ->required()
                                            ->toolbarButtons([
                                                'bold',
                                                'italic',
                                                'underline',
                                                'bulletList',
                                                'orderedList',
                                                'link',
                                            ])
                                            ->columnSpanFull(),
                                    ])
                            )->toArray()
                        )
                        ->columnSpanFull()
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        $columns = [];
        
        $columns[] = Tables\Columns\TextColumn::make('id')
            ->sortable();

        $columns[] = Tables\Columns\TextColumn::make('name_' . app()->getLocale())
            ->label(__('Name'))
            ->sortable()
            ->searchable();
        
        $columns[] = Tables\Columns\TextColumn::make('parentCategory.name_' . app()->getLocale())
            ->label(__('Parent category'));

        $columns[] = Tables\Columns\TextColumn::make('breadcrumbs')
            ->label(__('Breadcrumbs'))
            ->state(function (ProductCategory $record): string {
                $breadcrumbs = array_reverse($record->buildBreadcrumbs($record->id));
                return collect($breadcrumbs)
                    ->pluck('name')
                    ->join(' > ');
            })
            ->searchable(false)
            ->wrap();
        return $table
            ->columns($columns)
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('parent_id')
                    ->label(__('Parent category'))
                    ->relationship('parentCategory', 'name_' . LaravelLocalization::getCurrentLocale())
                    ->searchable()
                    ->preload()
                    ->indicateUsing(function (array $data): ?string {
                        if (!$data['value']) {
                            return null;
                        }
                        
                        $category = ProductCategory::query()->find($data['value']);
                        return $category ? $category->{'name_' . LaravelLocalization::getCurrentLocale()} : null;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->label(__('Edit'))
                    ->icon('heroicon-o-pencil'),
                DeleteAction::make()
                    ->label(__('Delete'))
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => Pages\ListProductCategories::route('/'),
            'create' => Pages\CreateProductCategory::route('/create'),
            'edit' => Pages\EditProductCategory::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Product category');
    }

    // Get plural label function
    public static function getPluralModelLabel(): string
    {
        return __('Product categories');
    }

    // Navigation group function
    public static function getNavigationGroup(): string
    {
        return __('Manage products');
    }
}
