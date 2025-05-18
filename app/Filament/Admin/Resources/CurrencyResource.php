<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CurrencyResource\Pages;
use App\Filament\Admin\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Company;
use Filament\Facades\Filament;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function form(Form $form): Form
    {
        $user = Filament::auth()->user();
        $hasCompany = $user && $user->company_id;

        return $form
            ->columns([
                'default' => 1,
                'sm' => 3,
                'lg' => 3,
            ])
            ->schema([
                Section::make(__('Currency Information'))
                    ->columnSpan([
                        'default' => 1,
                        'sm' => 3,
                        'lg' => 3,
                    ])
                    ->schema([
                        Select::make('company_id')
                            ->label(__('Company'))
                            ->options(Company::pluck('legal_name', 'id'))
                            ->required()
                            ->disabled($hasCompany)
                            ->default($hasCompany ? $user->company_id : null)
                            ->dehydrated(true)
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 3,
                                'lg' => 3,
                            ]),

                        TextInput::make('name')
                            ->label(__('Name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 1,
                                'lg' => 1,
                            ]),

                        TextInput::make('code')
                            ->label(__('Currency Code'))
                            ->required()
                            ->maxLength(3)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('ISO 4217 currency code (e.g., USD, EUR, GBP)'))
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 1,
                                'lg' => 1,
                            ]),

                        TextInput::make('symbol')
                            ->label(__('Currency Symbol'))
                            ->required()
                            ->maxLength(10)
                            ->helperText(__('Currency symbol (e.g., $, €, £)'))
                            ->columnSpan([
                                'default' => 1,
                                'sm' => 1,
                                'lg' => 1,
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label(__('ID'))
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label(__('Currency Code'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('symbol')
                    ->label(__('Symbol'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Updated At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('Deleted At'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
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
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Currency');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Currencies');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }
}
