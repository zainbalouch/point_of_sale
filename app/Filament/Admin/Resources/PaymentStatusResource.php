<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PaymentStatusResource\Pages;
use App\Filament\Admin\Resources\PaymentStatusResource\RelationManagers;
use App\Models\PaymentStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PaymentStatusResource extends Resource
{
    protected static ?string $model = PaymentStatus::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Sales';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Status Information')
                    ->schema([
                        Forms\Components\TextInput::make('name_en')
                            ->label('Name (English)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Pending, Completed, Failed, Refunded')
                            ->columnSpan(['sm' => 1, 'md' => 1]),
                        
                        Forms\Components\TextInput::make('name_ar')
                            ->label('Name (Arabic)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Arabic translation')
                            ->columnSpan(['sm' => 1, 'md' => 1]),
                        
                        Forms\Components\ColorPicker::make('color')
                            ->label('Status Color')
                            ->required()
                            ->helperText('Choose a color that represents this payment status')
                            ->columnSpan(['sm' => 2, 'md' => 2]),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Preview')
                    ->schema([
                        Forms\Components\Placeholder::make('preview')
                            ->label('Status Badge Preview')
                            ->content(function (Forms\Get $get): string {
                                $name = $get('name_en') ?: 'Payment Status';
                                $color = $get('color') ?: '#6b7280';
                                return "This is how the payment status will appear in the payments list:";
                            })
                            ->helperText(function (Forms\Get $get): string {
                                $name = $get('name_en') ?: 'Payment Status';
                                $color = $get('color') ?: '#6b7280';
                                return "<div style=\"display: inline-block; background-color: {$color}; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px;\">{$name}</div>";
                            })
                            ->columnSpan(['sm' => 2, 'md' => 2]),
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
                    
                Tables\Columns\ColorColumn::make('color')
                    ->label('Color'),
                    
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Preview')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => $state)
                    ->color(fn (PaymentStatus $record): string => $record->color),
                    
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
            ])
            ->defaultSort('name_en');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentStatuses::route('/'),
            'create' => Pages\CreatePaymentStatus::route('/create'),
            'view' => Pages\ViewPaymentStatus::route('/{record}'),
            'edit' => Pages\EditPaymentStatus::route('/{record}/edit'),
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
        return static::getModel()::count();
    }
    
    public static function getModelLabel(): string
    {
        return __('Payment Status');
    }
    
    public static function getPluralModelLabel(): string
    {
        return __('Payment Statuses');
    }
}
