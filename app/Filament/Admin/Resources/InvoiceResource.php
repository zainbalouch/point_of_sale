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
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Facades\Filament;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);

        // Apply filtering based on user
        $user = Filament::auth()->user();

        // If user has a point_of_sale_id, they can only see invoices from their POS
        if ($user && $user->point_of_sale_id) {
            $query->where('point_of_sale_id', $user->point_of_sale_id);
        }
        // If user has a company_id but no point_of_sale_id, they can see all invoices from their company
        elseif ($user && $user->company_id) {
            $query->where('company_id', $user->company_id);
        }

        return $query;
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
                                    ->disabled()
                                    ->readOnly()
                                    ->placeholder(__('Will be generated automatically'))
                                    ->dehydrated(false),
                                DatePicker::make('issue_date')
                                    ->label(__('Issue Date'))
                                    ->required()
                                    ->default(now()),
                                TextInput::make('due_date')
                                    ->hidden()
                                    ->default(now()->addDays(30)),
                            ])
                            ->columns(2),
                    ]),

                Section::make(__('Order Details'))
                    ->schema([
                        Select::make('customer_id')
                            ->label(__('Customer'))
                            ->relationship('customer', 'first_name', fn ($query) => $query
                                ->select(['id', 'first_name', 'last_name'])
                                ->where('company_id', Filament::auth()->user()->company_id)
                                ->where('is_active', true)
                                ->when(Filament::auth()->user()->point_of_sale_id, function ($query) {
                                    return $query->where('point_of_sale_id', Filament::auth()->user()->point_of_sale_id);
                                })
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name}")
                            ->searchable(['first_name', 'last_name'])
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                // Reset order selection
                                $set('order_id', null);

                                // Reset all financial summary fields
                                $set('subtotal', null);
                                $set('discount', null);
                                $set('vat', null);
                                $set('other_taxes', null);
                                $set('total', null);
                                $set('amount_paid', null);
                                $set('amount_left', null);
                            }),

                        Select::make('order_id')
                            ->label(__('Order'))
                            ->options(function (Forms\Get $get) {
                                $customerId = $get('customer_id');
                                $query = \App\Models\Order::query()
                                    ->select(['orders.id', 'orders.number', 'orders.total', 'orders.amount_paid', 'orders.customer_name'])
                                    ->leftJoin('order_items', 'orders.id', '=', 'order_items.order_id')
                                    ->selectRaw("CONCAT(orders.number, ' - ', orders.customer_name, ' (Total: ', orders.total, ', Paid: ', orders.amount_paid, ', Items: ', COUNT(DISTINCT order_items.id), ')') as display_text")
                                    ->groupBy('orders.id', 'orders.number', 'orders.total', 'orders.amount_paid', 'orders.customer_name');

                                // If customer is selected, show only their orders
                                if ($customerId) {
                                    return $query->where('customer_id', $customerId)
                                        ->pluck('display_text', 'orders.id');
                                }

                                // If no customer selected, filter by POS ID if user has one
                                $user = Filament::auth()->user();
                                if ($user->point_of_sale_id) {
                                    $query->whereHas('customer', function ($q) use ($user) {
                                        $q->where('point_of_sale_id', $user->point_of_sale_id);
                                    });
                                }

                                return $query->pluck('display_text', 'orders.id');
                            })
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!$state) {
                                    $set('subtotal', null);
                                    $set('discount', null);
                                    $set('vat', null);
                                    $set('other_taxes', null);
                                    $set('total', null);
                                    $set('amount_paid', null);
                                    $set('amount_left', null);
                                    return;
                                }

                                $order = \App\Models\Order::find($state);
                                if ($order) {
                                    // Set the customer based on the selected order
                                    $set('customer_id', $order->customer_id);

                                    // Set financial fields
                                    $set('subtotal', $order->subtotal);
                                    $set('discount', $order->discount);
                                    $set('vat', $order->vat);
                                    $set('other_taxes', $order->other_taxes);
                                    $set('total', $order->total);
                                    $set('amount_paid', $order->amount_paid);
                                }
                            }),
                    ]),

                Section::make(__('Financial Summary'))
                    ->schema([
                        TextInput::make('subtotal')
                            ->label(__('Sub Total'))
                            ->numeric()
                            ->readOnly()
                            ->disabled(),

                        TextInput::make('discount')
                            ->label(__('Discount'))
                            ->numeric()
                            ->readOnly()
                            ->disabled(),

                        TextInput::make('vat')
                            ->label(__('VAT'))
                            ->numeric()
                            ->readOnly()
                            ->disabled(),

                        TextInput::make('other_taxes')
                            ->label(__('Other Taxes'))
                            ->numeric()
                            ->readOnly()
                            ->disabled(),

                        TextInput::make('total')
                            ->label(__('Total Amount'))
                            ->numeric()
                            ->readOnly()
                            ->disabled(),

                        TextInput::make('amount_paid')
                            ->label(__('Already Paid'))
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(true)
                            ->afterStateHydrated(function ($state, Forms\Set $set) {
                                $set('amount_paid', $state);
                            }),

                        TextInput::make('amount_left')
                            ->label(__('Amount Left'))
                            ->numeric()
                            ->placeholder(function (Forms\Get $get) {
                                $total = $get('total') ?? 0;
                                $amountPaid = $get('amount_paid') ?? 0;
                                return number_format($total - $amountPaid, 2);
                            })
                            ->live()
                            ->visible(function (Forms\Get $get) {
                                $total = $get('total') ?? 0;
                                $amountPaid = $get('amount_paid') ?? 0;
                                return $total != $amountPaid;
                            })
                            ->afterStateUpdated(function ($state, Forms\Set $set, Forms\Get $get) {
                                $amount_paid = $get('amount_paid') ?? 0;
                                $amountLeft = $state ?? 0;
                                $newAmountPaid = $amount_paid + $amountLeft;
                                $set('amount_paid', $newAmountPaid);
                            }),
                    ])
                    ->columns(2),
            ]);
    }

    public static function createInvoiceFromOrder($order, array $formData = [])
    {
        $invoice = new \App\Models\Invoice();
        $invoice->fill([
            'customer_id' => $order->customer_id,
            'customer_name' => $order->customer->first_name . ' ' . $order->customer->last_name,
            'customer_email' => $order->customer->email,
            'customer_phone' => $order->customer->phone,
            'company_id' => $order->company_id,
            'order_id' => $order->id,
            'subtotal' => $order->subtotal,
            'vat' => $order->vat,
            'other_taxes' => $order->other_taxes,
            'discount' => $order->discount,
            'total' => $order->total,
            'amount_paid' => $order->amount_paid + ($formData['amount_left'] ?? 0),
            'issue_date' => now(),
            'due_date' => now()->addDays(30),
            'invoice_status_id' => 1, // Assuming 1 is the ID for draft status
            'issued_by_user' => Filament::auth()->user()->id,
            'point_of_sale_id' => $order->point_of_sale_id,
        ]);
        $invoice->save();

        // Create invoice items from order items
        foreach ($order->items as $orderItem) {
            $invoiceItem = new \App\Models\InvoiceItem();
            $invoiceItem->fill([
                'invoice_id' => $invoice->id,
                'product_name_en' => $orderItem->product->name_en,
                'product_name_ar' => $orderItem->product->name_ar,
                'product_description_en' => $orderItem->product->description_en,
                'product_description_ar' => $orderItem->product->description_ar,
                'product_sku' => $orderItem->product->sku,
                'product_code' => $orderItem->product->code,
                'quantity' => $orderItem->quantity,
                'unit_price' => $orderItem->unit_price,
                'vat_amount' => $orderItem->vat_amount,
                'other_taxes_amount' => $orderItem->other_taxes_amount,
                'discount_amount' => $orderItem->discount_amount,
                'total_price' => $orderItem->total_price,
                'note' => $orderItem->note,
            ]);
            $invoiceItem->save();
        }

        return $invoice;
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
                    ->formatStateUsing(fn($record) => $record->customer ? "{$record->customer->first_name} {$record->customer->last_name}" : '')
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

                TextColumn::make('total')
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
                    ->getOptionLabelFromRecordUsing(fn($record) => "{$record->first_name} {$record->last_name}")
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
                                fn(Builder $query, $date): Builder => $query->whereDate('issue_date', '>=', $date),
                            )
                            ->when(
                                $data['issue_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('issue_date', '<=', $date),
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
                                fn(Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                            )
                            ->when(
                                $data['due_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\Action::make('printInvoice')
                    ->label(__('Print Invoice'))
                    ->icon('heroicon-o-printer')
                    ->url(fn ($record) => route('invoice.show', $record))
                    ->extraAttributes([
                        'onclick' => "event.preventDefault(); openPrintPreview(this.href)"
                    ])
                    ->visible(function (Invoice $record) {
                        $user = Filament::auth()->user();
                        return !$user->point_of_sale_id || $record->customer->point_of_sale_id === $user->point_of_sale_id;
                    }),
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
        return __('Invoices');
    }
}
