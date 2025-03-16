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

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
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
                                    ->email()
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true),
                                    
                                TextInput::make('phone_number')
                                    ->label(__('Phone Number'))
                                    ->tel()
                                    ->maxLength(20),
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
                                    ->preload(),
                                    
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
