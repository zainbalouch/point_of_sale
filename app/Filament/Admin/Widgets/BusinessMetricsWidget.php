<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Invoice;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BusinessMetricsWidget extends Widget implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static string $view = 'filament-widgets.widget';

    protected int | string | array $columnSpan = 'full';

    // Properties for date filtering
    public ?string $startDate = null;
    public ?string $endDate = null;

    // Quick filter selection
    public ?string $quickFilter = 'this_month';

    // Property for form data
    public array $data = [];

    public function mount(): void
    {
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');

        $this->data = [
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'quickFilter' => $this->quickFilter,
        ];
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make('Filter Data')
                ->icon('heroicon-o-funnel')
                ->collapsible()
                ->collapsed()
                ->schema([
                    ToggleButtons::make('quickFilter')
                        ->label('Filter')
                        ->hiddenLabel()
                        ->options([
                            'today' => 'Today',
                            'this_week' => 'This Week',
                            'this_month' => 'This Month',
                            'this_year' => 'This Year',
                            'all' => 'All',
                            'custom' => 'Custom',
                        ])
                        ->default('this_month')
                        ->live()
                        ->inline()
                        ->afterStateUpdated(function ($state, $set) {
                            $this->applyQuickFilter($state, $set);
                        })
                        ->columnSpanFull(),

                    DatePicker::make('startDate')
                        ->label('Start Date')
                        ->required()
                        ->columnSpan(4)
                        ->hidden(fn (callable $get) => $get('quickFilter') !== 'custom'),

                    DatePicker::make('endDate')
                        ->label('End Date')
                        ->required()
                        ->columnSpan(4)
                        ->hidden(fn (callable $get) => $get('quickFilter') !== 'custom'),

                    Forms\Components\Group::make([
                        Forms\Components\Placeholder::make('spacer')
                            ->label('')
                            ->hiddenLabel(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('filter')
                                ->label('Apply Custom Filter')
                                ->submit('filter')
                                ->color('primary')
                                ->size('lg')
                        ])
                        ->alignment('center'),
                    ])
                    ->columnSpan(2)
                    ->extraAttributes(['class' => 'flex items-end'])
                    ->hidden(fn (callable $get) => $get('quickFilter') !== 'custom'),
                ])
                ->columns(10),
        ];
    }

    protected function applyQuickFilter(string $filter, callable $set): void
    {
        if ($filter === 'custom') {
            // Don't change the dates, just show the custom fields
            return;
        }

        $today = Carbon::today();

        $dates = match ($filter) {
            'today' => [
                'startDate' => $today->format('Y-m-d'),
                'endDate' => $today->format('Y-m-d'),
            ],
            'this_week' => [
                'startDate' => $today->startOfWeek()->format('Y-m-d'),
                'endDate' => $today->endOfWeek()->format('Y-m-d'),
            ],
            'this_month' => [
                'startDate' => $today->startOfMonth()->format('Y-m-d'),
                'endDate' => $today->endOfMonth()->format('Y-m-d'),
            ],
            'this_year' => [
                'startDate' => $today->startOfYear()->format('Y-m-d'),
                'endDate' => $today->endOfYear()->format('Y-m-d'),
            ],
            'all' => [
                'startDate' => Carbon::parse('2000-01-01')->format('Y-m-d'),
                'endDate' => $today->addYears(10)->format('Y-m-d'),
            ],
            default => [
                'startDate' => $today->startOfMonth()->format('Y-m-d'),
                'endDate' => $today->endOfMonth()->format('Y-m-d'),
            ],
        };

        $set('startDate', $dates['startDate']);
        $set('endDate', $dates['endDate']);

        // Also update the widget properties to trigger an immediate refresh
        $this->startDate = $dates['startDate'];
        $this->endDate = $dates['endDate'];
        $this->quickFilter = $filter;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    protected function getViewData(): array
    {
        // Query orders within the date range
        $orders = Order::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->get();

        // Query invoices within the date range
        $invoices = Invoice::query()
            ->whereBetween('issue_date', [$this->startDate, $this->endDate . ' 23:59:59'])
            ->get();

        // Calculate metrics
        $orderCount = $orders->count();
        $invoiceCount = $invoices->count();
        $totalVat = $invoices->sum('vat');
        $totalIncome = $invoices->sum('total');
        $totalDiscounts = $invoices->sum('discount');
        $amountPaid = $invoices->sum('amount_paid');
        $amountRemaining = $totalIncome - $amountPaid;

        // Calculate total sale (sum of subtotals before taxes and discounts)
        $totalSale = $invoices->sum('subtotal');

        // Calculate profit (income minus VAT and discounts)
        $totalProfit = $totalIncome - $totalVat;

        return [
            'metrics' => [
                [
                    'label' => 'Orders',
                    'value' => $orderCount,
                    'icon' => 'heroicon-o-shopping-cart',
                ],
                [
                    'label' => 'Invoices',
                    'value' => $invoiceCount,
                    'icon' => 'heroicon-o-document-text',
                ],
                [
                    'label' => 'Total Sale',
                    'value' => number_format($totalSale, 2),
                    'icon' => 'heroicon-o-currency-dollar',
                ],
                [
                    'label' => 'Total Profit',
                    'value' => number_format($totalProfit, 2),
                    'icon' => 'heroicon-o-arrow-trending-up',
                ],
                [
                    'label' => 'VAT Collected',
                    'value' => number_format($totalVat, 2),
                    'icon' => 'heroicon-o-currency-dollar',
                ],
                [
                    'label' => 'Total Income',
                    'value' => number_format($totalIncome, 2),
                    'icon' => 'heroicon-o-banknotes',
                ],
                [
                    'label' => 'Total Discounts',
                    'value' => number_format($totalDiscounts, 2),
                    'icon' => 'heroicon-o-receipt-percent',
                ],
                [
                    'label' => 'Amount Paid',
                    'value' => number_format($amountPaid, 2),
                    'icon' => 'heroicon-o-credit-card',
                ],
                [
                    'label' => 'Amount Remaining',
                    'value' => number_format($amountRemaining, 2),
                    'icon' => 'heroicon-o-clock',
                ],
            ],
        ];
    }

    public function filter(): void
    {
        $data = $this->form->getState();
        $this->startDate = $data['startDate'];
        $this->endDate = $data['endDate'];
        $this->quickFilter = $data['quickFilter'];
    }

    protected function getFooter(): View
    {
        return view('filament-widgets.business-metrics-footer', [
            'startDate' => Carbon::parse($this->startDate)->format('M d, Y'),
            'endDate' => Carbon::parse($this->endDate)->format('M d, Y'),
        ]);
    }
}
