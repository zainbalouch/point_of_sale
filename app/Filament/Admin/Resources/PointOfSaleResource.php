<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PointOfSaleResource\Pages;
use App\Filament\Admin\Resources\PointOfSaleResource\RelationManagers;
use App\Models\PointOfSale;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PointOfSaleResource extends Resource
{
    protected static ?string $model = PointOfSale::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('Basic information'))
                    ->schema([
                        Forms\Components\Select::make('company_id')
                            ->label(__('Company'))
                            ->relationship('company', 'legal_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(['sm' => 2]),

                        Forms\Components\TextInput::make('name_en')
                            ->label(__('Name (English)'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder('E.g., Main Store, Branch Office, Warehouse')
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\TextInput::make('name_ar')
                            ->label(__('Name (Arabic)'))
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Arabic translation')
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Active'))
                            ->default(true)
                            ->helperText(__('Inactive points of sale will not be available for transactions'))
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->inline(false)
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\RichEditor::make('description_en')
                            ->label(__('Description (English)'))
                            ->placeholder(__('Enter details about this point of sale'))
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\RichEditor::make('description_ar')
                            ->label(__('Description (Arabic)'))
                            ->placeholder(__('Arabic description'))
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->columnSpan(['sm' => 1]),

                        Forms\Components\Textarea::make('address')
                            ->label(__('Address'))
                            ->placeholder(__('Physical location of this point of sale'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                Forms\Components\Section::make('Additional Details')
                    ->schema([
                        Forms\Components\KeyValue::make('meta')
                            ->label(__('Additional Metadata'))
                            ->keyLabel(__('Key'))
                            ->valueLabel(__('Value'))
                            ->addButtonLabel(__('Add Field'))
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
                Tables\Columns\TextColumn::make('name_en')
                    ->label(__('Name (English)'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_ar')
                    ->label(__('Name (Arabic)'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('company.legal_name')
                    ->label(__('Company'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Status'))
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('products_count')
                    ->label(__('Products'))
                    ->counts('products')
                    ->sortable(),

                Tables\Columns\TextColumn::make('users_count')
                    ->label(__('Staff'))
                    ->counts('users')
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
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('company_id')
                    ->relationship('company', 'legal_name')
                    ->label(__('Company'))
                    ->searchable()
                    ->preload(),

                Tables\Filters\SelectFilter::make('is_active')
                    ->label(__('Status'))
                    ->options([
                        '1' => __('Active'),
                        '0' => __('Inactive'),
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label(__('Created From')),
                        Forms\Components\DatePicker::make('created_until')
                            ->label(__('Created Until')),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),

                    Tables\Actions\BulkAction::make('activate')
                        ->label(__('Activate Selected'))
                        ->icon('heroicon-o-check')
                        ->action(fn (array $records) => PointOfSale::whereIn('id', $records)->update(['is_active' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),

                    Tables\Actions\BulkAction::make('deactivate')
                        ->label(__('Deactivate Selected'))
                        ->icon('heroicon-o-x-mark')
                        ->action(fn (array $records) => PointOfSale::whereIn('id', $records)->update(['is_active' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductsRelationManager::class,
            RelationManagers\UsersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPointOfSales::route('/'),
            'create' => Pages\CreatePointOfSale::route('/create'),
            'view' => Pages\ViewPointOfSale::route('/{record}'),
            'edit' => Pages\EditPointOfSale::route('/{record}/edit'),
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
        return $record->name_en;
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name_en', 'name_ar', 'description_en', 'description_ar'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            __('Company') => $record->company->legal_name,
            __('Status') => $record->is_active ? __('Active') : __('Inactive'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Point of Sale');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Points of Sale');
    }

    public static function getNavigationGroup(): string
    {
        return __('Points of Sale');
    }
}
