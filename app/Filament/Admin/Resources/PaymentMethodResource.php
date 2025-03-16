<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentMethodResource\Pages;
use App\Filament\Admin\Resources\PaymentMethodResource\RelationManagers;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Method Information')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Credit Card, PayPal, Cash on Delivery')
                            ->columnSpan(['sm' => 1]),
                        
                        Forms\Components\TextInput::make('name_ar')
                            ->label('Name (Arabic)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Arabic translation')
                            ->columnSpan(['sm' => 1]),
                        
                        Forms\Components\TextInput::make('code')
                            ->label('Code')
                            ->required()
                            ->maxLength(50)
                            ->placeholder('e.g., cc, paypal, cod')
                            ->helperText('Unique code used by the system to identify this payment method')
                            ->columnSpan(['sm' => 1]),
                        
                        Forms\Components\TextInput::make('icon')
                            ->label('Icon')
                            ->maxLength(255)
                            ->placeholder('e.g., fa-credit-card, heroicon-o-currency-dollar')
                            ->helperText('Icon class name or identifier. Leave empty if not applicable')
                            ->columnSpan(['sm' => 1]),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active payment methods are shown to customers')
                            ->onIcon('heroicon-m-check')
                            ->offIcon('heroicon-m-x-mark')
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Preview')
                    ->schema([
                        Forms\Components\Placeholder::make('preview')
                            ->label('Payment Method Preview')
                            ->content(function (Forms\Get $get): string {
                                $name = $get('name_en') ?: 'Payment Method';
                                $icon = $get('icon') ? "<i class=\"{$get('icon')}\"></i>" : '';
                                $active = $get('is_active') ? 'Active' : 'Inactive';
                                $code = $get('code') ?: 'payment-code';
                                
                                return "This is how the payment method will appear:";
                            })
                            ->helperText(function (Forms\Get $get): string {
                                $name = $get('name_en') ?: 'Payment Method';
                                $icon = $get('icon') ? "<i class=\"{$get('icon')}\"></i> " : '';
                                $active = $get('is_active') ? 'Active' : 'Inactive';
                                $code = $get('code') ?: 'payment-code';
                                
                                return "
                                <div style=\"display: flex; align-items: center; padding: 10px; border: 1px solid #e5e7eb; border-radius: 8px; margin-top: 8px;\">
                                    {$icon}<span style=\"font-weight: 500; margin-right: 8px;\">{$name}</span>
                                    <span style=\"background-color: " . ($get('is_active') ? '#10b981' : '#ef4444') . "; color: white; font-size: 12px; padding: 2px 6px; border-radius: 4px; margin-left: auto;\">{$active}</span>
                                </div>
                                <div style=\"margin-top: 8px; font-size: 12px; color: #6b7280;\">Code: <code>{$code}</code></div>
                                ";
                            })
                            ->columnSpan(['sm' => 2]),
                    ])
                    ->collapsed(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Name (English)')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name_ar')
                    ->label('Name (Arabic)')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('code')
                    ->label('Code')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('icon')
                    ->label('Icon')
                    ->formatStateUsing(fn (string $state): string => $state ? "<i class=\"{$state}\"></i> {$state}" : '-')
                    ->html()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('payments_count')
                    ->label('Payments')
                    ->counts('payments')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                
                Tables\Filters\SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
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
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check')
                        ->action(fn (PaymentMethod $records) => $records->each->update(['is_active' => true]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    
                    Tables\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-mark')
                        ->action(fn (PaymentMethod $records) => $records->each->update(['is_active' => false]))
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            // We can add PaymentsRelationManager if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'view' => Pages\ViewPaymentMethod::route('/{record}'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::active()->count();
    }
    
    public static function getModelLabel(): string
    {
        return __('Payment Method');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Payment Methods');
    }
}
