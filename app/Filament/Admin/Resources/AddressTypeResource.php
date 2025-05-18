<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AddressTypeResource\Pages;
use App\Filament\Admin\Resources\AddressTypeResource\RelationManagers;
use App\Models\AddressType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Models\Company;
use Filament\Facades\Filament;

class AddressTypeResource extends Resource
{
    protected static ?string $model = AddressType::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        $locals = LaravelLocalization::getSupportedLocales();
        $user = Filament::auth()->user();
        $hasCompany = $user && $user->company_id;

        return $form
            ->columns([
                'default' => 1,
                'sm' => 3,
                'lg' => 3,
            ])
            ->schema([
                Section::make(__('Address Type Information'))
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
                            ->dehydrated(true),
                        ...collect($locals)->flatMap(fn ($properties, $locale) => [
                            TextInput::make("name_{$locale}")
                                ->label(__('Name') . " ({$properties['native']})")
                                ->required()
                                ->maxLength(255),
                        ])->toArray(),
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

                Tables\Columns\TextColumn::make('name_' . app()->getLocale())
                    ->label(__('Name'))
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAddressTypes::route('/'),
            'create' => Pages\CreateAddressType::route('/create'),
            'edit' => Pages\EditAddressType::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Address type');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Address types');
    }

    public static function getNavigationGroup(): string
    {
        return __('Settings');
    }
}
