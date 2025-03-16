<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InvoiceResource\Pages;
use App\Filament\Admin\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

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
                Section::make(__('Invoice Details'))
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('number')
                                    ->label(__('Invoice Number'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->placeholder(__('INV-00001')),
                                    
                                Select::make('invoice_status_id')
                                    ->label(__('Status'))
                                    ->relationship('status', 'name_' . app()->getLocale())
                                    ->preload()
                                    ->required(),
                            ])
                            ->columns(2),
                            
                        Grid::make()
                            ->schema([
                                DatePicker::make('issue_date')
                                    ->label(__('Issue Date'))
                                    ->required()
                                    ->default(now()),
                                    
                                DatePicker::make('due_date')
                                    ->label(__('Due Date'))
                                    ->required()
                                    ->default(now()->addDays(30)),
                            ])
                            ->columns(2),
                    ]),
                    
                Section::make(__('Customer & Billing'))
                    ->schema([
                        Grid::make()
                            ->schema([
                                Select::make('customer_id')
                                    ->label(__('Customer'))
                                    ->relationship('customer', 'first_name', function ($query) {
                                        return $query->select(['id', 'first_name', 'last_name'])
                                            ->selectRaw("CONCAT(first_name, ' ', last_name) as full_name");
                                    })
                                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                                    ->searchable(['first_name', 'last_name', 'email'])
                                    ->preload()
                                    ->required(),
                                    
                                Select::make('company_id')
                                    ->label(__('Company'))
                                    ->relationship('company', 'legal_name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                            ])
                            ->columns(2),

                        Grid::make()
                            ->schema([
                                Select::make('billing_address_id')
                                    ->label(__('Billing Address'))
                                    ->relationship('billingAddress', 'street')
                                    ->searchable()
                                    ->preload(),
                                    
                                Select::make('shipping_address_id')
                                    ->label(__('Shipping Address'))
                                    ->relationship('shippingAddress', 'street')
                                    ->searchable()
                                    ->preload(),
                            ])
                            ->columns(2),
                    ]),
                    
                Section::make(__('Financial Details'))
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('subtotal')
                                    ->label(__('Subtotal'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                                    
                                TextInput::make('tax_amount')
                                    ->label(__('Tax Amount'))
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                            ->columns(2),
                            
                        Grid::make()
                            ->schema([
                                TextInput::make('discount_amount')
                                    ->label(__('Discount Amount'))
                                    ->numeric()
                                    ->prefix('$')
                                    ->default(0),
                                    
                                TextInput::make('total_amount')
                                    ->label(__('Total Amount'))
                                    ->required()
                                    ->numeric()
                                    ->prefix('$'),
                            ])
                            ->columns(2),
                            
                        Textarea::make('meta.notes')
                            ->label(__('Notes'))
                            ->rows(3)
                            ->placeholder(__('Any additional notes for this invoice')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('number')
                    ->label(__('Invoice #'))
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('customer.first_name')
                    ->label(__('Customer'))
                    ->formatStateUsing(fn ($record) => $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : '')
                    ->searchable(['customer.first_name', 'customer.last_name'])
                    ->sortable(['customer.first_name']),
                    
                TextColumn::make('issue_date')
                    ->label(__('Issue Date'))
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('due_date')
                    ->label(__('Due Date'))
                    ->date()
                    ->sortable(),
                    
                TextColumn::make('status.name_' . app()->getLocale())
                    ->label(__('Status'))
                    ->formatStateUsing(function ($state, $record) {
                        return $state ?: ($record->isPaid() ? 'Paid' : ($record->isOverdue() ? 'Overdue' : 'Draft'));
                    })
                    ->badge()
                    ->color(function ($state, $record) {
                        if (!$state) {
                            return $record->isPaid() ? 'success' : ($record->isOverdue() ? 'danger' : 'secondary');
                        }
                        
                        return match (strtolower($state)) {
                            'draft' => 'secondary',
                            'sent' => 'primary',
                            'paid' => 'success',
                            'overdue' => 'danger',
                            'cancelled' => 'warning',
                            default => 'secondary',
                        };
                    })
                    ->searchable()
                    ->sortable(),
                    
                TextColumn::make('total_amount')
                    ->label(__('Total'))
                    ->money('USD')
                    ->sortable(),
                    
                TextColumn::make('created_at')
                    ->label(__('Created'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                TextColumn::make('updated_at')
                    ->label(__('Updated'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                
                Tables\Filters\SelectFilter::make('invoice_status_id')
                    ->relationship('status', 'name_' . app()->getLocale())
                    ->label(__('Status'))
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\SelectFilter::make('customer_id')
                    ->relationship('customer', 'first_name', function ($query) {
                        return $query->select(['id', 'first_name', 'last_name'])
                            ->selectRaw("CONCAT(first_name, ' ', last_name) as full_name");
                    })
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                    ->label(__('Customer'))
                    ->searchable()
                    ->preload(),
                    
                Tables\Filters\Filter::make('issue_date')
                    ->form([
                        Forms\Components\DatePicker::make('issue_from')
                            ->label(__('Issued From')),
                        Forms\Components\DatePicker::make('issue_until')
                            ->label(__('Issued Until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['issue_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('issue_date', '>=', $date),
                            )
                            ->when(
                                $data['issue_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('issue_date', '<=', $date),
                            );
                    }),
                    
                Tables\Filters\Filter::make('due_date')
                    ->form([
                        Forms\Components\DatePicker::make('due_from')
                            ->label(__('Due From')),
                        Forms\Components\DatePicker::make('due_until')
                            ->label(__('Due Until')),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['due_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                            )
                            ->when(
                                $data['due_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // Line items relation will be implemented here
            // RelationManagers\LineItemsRelationManager::class,
            // RelationManagers\PaymentsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
    
    public static function getModelLabel(): string
    {
        return __('Invoice');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Invoices');
    }

    public static function getNavigationGroup(): string
    {
        return __('Sales');
    }
}
