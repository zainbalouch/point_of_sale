<?php

namespace App\Filament\SuperAdmin\Resources;

use App\Filament\SuperAdmin\Resources\TenantResource\Pages;
use App\Models\Tenant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TenantResource extends Resource
{
    protected static ?string $model = Tenant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    // Temporary storage for the domain value
    protected static ?string $pendingDomain = null;

    public static function form(Form $form): Form
    {
        $centralDomain = env('CENTRAL_DOMAIN');
        $suffix = $centralDomain ? '.' . $centralDomain : '';

        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\TextInput::make('domain')
                    ->label('Subdomain')
                    ->required()
                    ->suffix($suffix) // Display .CENTRAL_DOMAIN as a suffix
                    ->helperText('Enter the desired subdomain. It will be combined with '.env('CENTRAL_DOMAIN').' (e.g., if you enter \'mytenant\', the domain will be \'mytenant.'.env('CENTRAL_DOMAIN').')')
                    ->dehydrated(true),
                Forms\Components\TextInput::make('tax_number')
                    ->label('Tax Number')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->helperText('Initial admin password for the new tenant.'),
                Forms\Components\TextInput::make('phone')
                    ->label('Phone')
                    ->tel(),
                Forms\Components\Textarea::make('address')
                    ->label('Address'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('domains.domain') // Kept as per user's last version for display
                    ->label('Domain')
                    ->copyable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // DomainsRelationManager::class, // Remains commented out
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTenants::route('/'),
            'create' => Pages\CreateTenant::route('/create'),
            'view' => Pages\ViewTenant::route('/{record}'),
            'edit' => Pages\EditTenant::route('/{record}/edit'),
        ];
    }

}
