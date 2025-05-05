<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Widgets\Widget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BusinessMetricsWidget extends Widget implements Forms\Contracts\HasForms
{
    use HasWidgetShield;
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
            Section::make(__('Filter Data'))
                ->icon('heroicon-o-funnel')
                ->collapsible()
                ->collapsed()
                ->schema([
                    ToggleButtons::make('quickFilter')
                        ->label(__('Filter'))
                        ->hiddenLabel()
                        ->options([
                            'today' => __('Today'),
                            'this_week' => __('This Week'),
                            'this_month' => __('This Month'),
                            'this_year' => __('This Year'),
                            'all' => __('All'),
                            'custom' => __('Custom'),
                        ])
                        ->default('this_month')
                        ->live()
                        ->inline()
                        ->afterStateUpdated(function ($state, $set) {
                            $this->applyQuickFilter($state, $set);
                        })
                        ->columnSpanFull(),

                    DatePicker::make('startDate')
                        ->label(__('Start Date'))
                        ->required()
                        ->columnSpan(4)
                        ->hidden(fn (callable $get) => $get('quickFilter') !== 'custom'),

                    DatePicker::make('endDate')
                        ->label(__('End Date'))
                        ->required()
                        ->columnSpan(4)
                        ->hidden(fn (callable $get) => $get('quickFilter') !== 'custom'),

                    Forms\Components\Group::make([
                        Forms\Components\Placeholder::make('spacer')
                            ->label('')
                            ->hiddenLabel(),
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('filter')
                                ->label(__('Apply Custom Filter'))
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

    protected function applyUserAccessFilters(Builder $query): Builder
    {
        $user = Auth::user();

        // If user has point_of_sale_id, filter by that specific POS
        if ($user->point_of_sale_id) {
            return $query->where('point_of_sale_id', $user->point_of_sale_id);
        }

        // If user has company_id but no POS, show all POS data for that company
        if ($user->company_id) {
            return $query->where('company_id', $user->company_id);
        }

        // If user has neither, they see all data (likely an admin)
        return $query;
    }

    protected function getViewData(): array
    {
        // Query orders within the date range with user access filters
        $ordersQuery = Order::query()
            ->whereBetween('created_at', [$this->startDate, $this->endDate . ' 23:59:59']);
        $ordersQuery = $this->applyUserAccessFilters($ordersQuery);
        $orders = $ordersQuery->get();

        // Query invoices within the date range with user access filters
        $invoicesQuery = Invoice::query()
            ->whereBetween('issue_date', [$this->startDate, $this->endDate . ' 23:59:59']);
        $invoicesQuery = $this->applyUserAccessFilters($invoicesQuery);
        $invoices = $invoicesQuery->get();

        // Get products data with user access filters
        $productsQuery = Product::query();
        $productsQuery = $this->applyUserAccessFilters($productsQuery);
        $products = $productsQuery->get();

        $totalStock = $products->sum('quantity');
        $outOfStockCount = $products->where('quantity', '<=', 0)->count();

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
                    'label' => __('Orders'),
                    'value' => $orderCount,
                    'icon' => 'heroicon-o-shopping-cart',
                ],
                [
                    'label' => __('Invoices'),
                    'value' => $invoiceCount,
                    'icon' => 'heroicon-o-document-text',
                ],
                [
                    'label' => __('Total Sale'),
                    'value' => number_format($totalSale, 2),
                    'icon' => 'heroicon-o-currency-dollar',
                ],
                [
                    'label' => __('Total Profit'),
                    'value' => number_format($totalProfit, 2),
                    'icon' => 'heroicon-o-arrow-trending-up',
                ],
                [
                    'label' => __('VAT Collected'),
                    'value' => number_format($totalVat, 2),
                    'icon' => 'heroicon-o-currency-dollar',
                ],
                [
                    'label' => __('Total Income'),
                    'value' => number_format($totalIncome, 2),
                    'icon' => 'heroicon-o-banknotes',
                ],
                [
                    'label' => __('Total Discounts'),
                    'value' => number_format($totalDiscounts, 2),
                    'icon' => 'heroicon-o-receipt-percent',
                ],
                [
                    'label' => __('Amount Paid'),
                    'value' => number_format($amountPaid, 2),
                    'icon' => 'heroicon-o-credit-card',
                ],
                [
                    'label' => __('Amount Remaining'),
                    'value' => number_format($amountRemaining, 2),
                    'icon' => 'heroicon-o-clock',
                ],
                [
                    'label' => __('Stock Remaining'),
                    'value' => $totalStock,
                    'icon' => 'heroicon-o-cube',
                ],
                [
                    'label' => __('Out of Stock'),
                    'value' => $outOfStockCount,
                    'icon' => 'heroicon-o-exclamation-triangle',
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
        $user = Auth::user();
        $contextInfo = '';

        if ($user->point_of_sale_id) {
            $posName = $user->pointOfSale->name ?? __('Selected Point of Sale');
            $contextInfo = __(' for :posName', ['posName' => $posName]);
        } elseif ($user->company_id) {
            $companyName = $user->company->name ?? __('Your Company');
            $contextInfo = __(' for all points of sale in :companyName', ['companyName' => $companyName]);
        }

        return view('filament-widgets.business-metrics-footer', [
            'startDate' => Carbon::parse($this->startDate)->format('M d, Y'),
            'endDate' => Carbon::parse($this->endDate)->format('M d, Y'),
            'contextInfo' => $contextInfo,
        ]);
    }
}
