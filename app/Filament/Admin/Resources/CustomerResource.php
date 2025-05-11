<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CustomerResource\Pages;
use App\Filament\Admin\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // Apply filtering based on user
        $user = Filament::auth()->user();

        // If user has a point_of_sale_id, they can only see customers from their POS
        if ($user && $user->point_of_sale_id) {
            $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        // If user has a company_id but no point_of_sale_id, they can see all customers from their company
        elseif ($user && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Personal Information'))
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('first_name')
                                    ->label(__('First Name'))
                                    ->required()
                                    ->maxLength(255),

                                TextInput::make('last_name')
                                    ->label(__('Last Name'))
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->columns(2),

                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('email')
                                    ->label(__('Email'))
                                    ->required()
                                    ->email()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),

                                TextInput::make('phone_number')
                                    ->label(__('Phone Number'))
                                    ->tel()
                                    ->required()
                                    ->maxLength(20),
                            ])
                            ->columns(2),

                        Forms\Components\Grid::make()
                            ->schema([
                                TextInput::make('vat_number')
                                    ->label(__('VAT Number'))
                                    ->maxLength(255),

                                TextInput::make('address')
                                    ->label(__('Address'))
                                    ->maxLength(1000),
                            ])
                            ->columns(2),
                    ]),

                Section::make(__('Company & Settings'))
                    ->schema([
                        Forms\Components\Grid::make()
                            ->schema([
                                Select::make('company_id')
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

                                Select::make('point_of_sale_id')
                                    ->label(__('Point of Sale'))
                                    ->relationship('pointOfSale', 'name_en')
                                    ->searchable()
                                    ->required()
                                    ->preload()
                                    ->options(function (Forms\Get $get) {
                                        $companyId = $get('company_id');
                                        if (!$companyId) {
                                            return [];
                                        }
                                        return \App\Models\PointOfSale::where('company_id', $companyId)
                                            ->pluck('name_en', 'id');
                                    })
                                    ->default(function () {
                                        $user = Filament::auth()->user();
                                        return $user->point_of_sale_id;
                                    })
                                    ->disabled(function () {
                                        $user = Filament::auth()->user();
                                        return $user->point_of_sale_id !== null;
                                    })
                                    ->dehydrated(),

                                Toggle::make('is_active')
                                    ->label(__('Active Status'))
                                    ->helperText(__('Whether the customer is active'))
                                    ->default(true),
                            ])
                            ->columns(2),
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

                Tables\Columns\TextColumn::make('full_name')
                    ->label(__('Full Name'))
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('phone_number')
                    ->label(__('Phone'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('vat_number')
                    ->label(__('VAT Number'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('address')
                    ->label(__('Address'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('company.legal_name')
                    ->label(__('Company'))
                    ->searchable()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean()
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
                Tables\Filters\SelectFilter::make('company_id')
                    ->relationship('company', 'legal_name')
                    ->label(__('Company'))
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('is_active')
                    ->label(__('Active Status'))
                    ->toggle()
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->visible(function (Customer $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\EditAction::make()
                    ->visible(function (Customer $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                    }),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Customer $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->point_of_sale_id === $user->point_of_sale_id;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
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
            // Relations will be implemented later
            // RelationManagers\OrdersRelationManager::class,
            // RelationManagers\AddressesRelationManager::class,
            // RelationManagers\NotesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Customer');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Customers');
    }

    public static function getNavigationGroup(): string
    {
        return __('Sales');
    }

}
