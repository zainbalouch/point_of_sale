<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';


    public static function getModelLabel(): string
    {
        return __('User');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label(__('First Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('last_name')
                    ->label(__('Last Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label(__('Phone Number'))
                    ->tel()
                    ->maxLength(255),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
                Select::make('company_id')
                    ->label(__('Company'))
                    ->relationship('company', 'legal_name')
                    ->required(function (Forms\Get $get) {
                        $roles = $get('roles');
                        $roleNames = Role::whereIn('id', $roles)->pluck('name')->toArray();
                        $hasSuperAdmin = in_array('super_admin', $roleNames);
                        $isOnlySuperAdmin = count($roleNames) === 1 && $hasSuperAdmin;
                        return !$isOnlySuperAdmin;
                    })
                    ->live(),
                Select::make('point_of_sale_id')
                    ->label(__('Point of Sale'))
                    ->required(function (Forms\Get $get) {
                        $roles = $get('roles');
                        $roleNames = Role::whereIn('id', $roles)->pluck('name')->toArray();
                        $hasSuperAdmin = in_array('super_admin', $roleNames);
                        $isOnlySuperAdmin = count($roleNames) === 1 && $hasSuperAdmin;
                        return !$isOnlySuperAdmin;
                    })
                    ->options(function (Forms\Get $get) {
                        $companyId = $get('company_id');
                        if (!$companyId) {
                            return [];
                        }
                        return \App\Models\PointOfSale::where('company_id', $companyId)
                            ->where('is_active', true)
                            ->get()
                            ->pluck('name', 'id');
                    })
                    ->searchable()
                    ->preload(),
                Select::make('roles')
                    ->label(__('Roles'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->required()
                    ->live(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label(__('First Name'))
                    ->searchable(),
                TextColumn::make('last_name')
                    ->label(__('Last Name'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->label(__('Phone Number'))
                    ->searchable(),
                TextColumn::make('company.legal_name')
                    ->label(__('Company'))
                    ->searchable(),
                TextColumn::make('pointOfSale.name')
                    ->label(__('Point of Sale'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->badge(),
                TextColumn::make('email_verified_at')
                    ->label(__('Email verified at'))
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
