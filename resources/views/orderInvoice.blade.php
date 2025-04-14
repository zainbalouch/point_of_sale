<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/invoice.css') }}" />
    @if (app()->getLocale() === 'ar')
        <style>
            body {
                font-family: 'Poppins', 'Tahoma', sans-serif;
                text-align: right;
            }

            .invoice-text-end {
                text-align: left !important;
            }

            .invoice-text-start {
                text-align: right !important;
            }

            .order-0 {
                order: 1 !important;
            }

            .order-1 {
                order: 0 !important;
            }
        </style>
    @else
        <style>
            .invoice-text-end {
                text-align: right !important;
            }

            .invoice-text-start {
                text-align: left !important;
            }
        </style>
    @endif

    <style>
        @media print {

            /* This class will be repeated on each page */
            .header-print {
                display: table-header-group;
            }

            /* For page breaks */
            .page-break {
                page-break-before: always;
            }
        }

        .header,
        .header-space,
        .footer,
        .footer-space {
            height: 100px;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <td>
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <main>
                        <div class="row">
                            <div class="col-6"><strong>{{ __('Date') }}:</strong>
                                @if (app()->getLocale() === 'ar')
                                    {{ $order->created_at->format('Y/m/d') }}
                                @else
                                    {{ $order->created_at->format('d/m/Y') }}
                                @endif
                            </div>
                            <div class="col-6 invoice-text-end"> <strong>{{ __('Order No') }}:</strong>
                                {{ $order->number }}
                            </div>

                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-6 text-end order-1"> <strong>{{ __('Pay To') }}:</strong>
                                <address>
                                    {{ $order->company->legal_name }}<br />
                                    @if ($order->pointOfSale)
                                        {{ $order->pointOfSale->{'name_' . app()->getLocale()} }}<br />
                                    @endif
                                    @if ($order->company->addresses->isNotEmpty())
                                        {{ $order->company->addresses->first()->street }}<br />
                                        {{ $order->company->addresses->first()->postal_code ?? '' }}
                                        {{ $order->company->addresses->first()->country->name ?? '' }}<br />
                                    @endif
                                    {{ $order->company->email }} <br>
                                    {{ $order->company->tax_number }}
                                </address>
                            </div>
                            <div class="col-6 order-0"> <strong>{{ __('Invoiced To') }}:</strong>
                                <address>
                                    @if ($order->customer)
                                        {{ $order->customer->full_name }}<br />
                                        @if ($order->customer->address)
                                            {{ $order->customer->address }}<br />
                                        @endif
                                        {{ $order->customer->email }}<br />
                                        {{ $order->customer->phone_number }}
                                    @else
                                        {{ $order->customer_name ?? 'N/A' }}<br />
                                        {{ $order->customer_email ?? '' }}<br />
                                        {{ $order->customer_phone_number ?? '' }}
                                    @endif
                                </address>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <td class="col-4"><strong>{{ __('Products') }}</strong></td>
                                        <td class="col-1 text-center"><strong>{{ __('Quantity') }}</strong></td>
                                        <td class="col-2 text-center"><strong>{{ __('Unit Price') }}</strong></td>
                                        <td class="col-2 text-center"><strong>{{ __('Discount') }}</strong></td>
                                        <td class="col-2 text-center"><strong>{{ __('VAT') }}</strong></td>
                                        @if ($order->other_taxes > 0)
                                            <td class="col-2 text-center"><strong>{{ __('Other Taxes') }}</strong></td>
                                        @endif
                                        <td class="col-2 invoice-text-end"><strong>{{ __('Items Subtotal') }}</strong>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="col-4">
                                                {{ $item->{'product_name_' . app()->getLocale()} }}
                                                @if (!empty($item->note))
                                                    <br><small class="text-muted">{{ $item->note }}</small>
                                                @endif
                                            </td>
                                            <td class="col-1 text-center">{{ $item->quantity }}</td>
                                            <td class="col-2 text-center">
                                                {{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="col-2 text-center">
                                                {{ number_format($item->discount_amount ?? 0, 2) }}
                                            </td>
                                            <td class="col-2 text-center">
                                                {{ number_format($item->vat_amount ?? 0, 2) }}
                                            </td>
                                            @if ($order->other_taxes > 0)
                                                <td class="col-2 text-center">
                                                    {{ number_format($item->other_taxes_amount ?? 0, 2) }}
                                                </td>
                                            @endif
                                            <td class="col-2 invoice-text-end">
                                                {{ number_format($item->total_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table border border-top-0 mb-0">
                                        <tr>
                                            <td class="col-3 invoice-text-end"><strong>{{ __('Subtotal') }}:</strong>
                                            </td>
                                            <td class="col-3 invoice-text-end">
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($order->subtotal, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($order->subtotal, 2) }}
                                                @endif
                                            </td>
                                            <td class="col-3 invoice-text-end"><strong>{{ __('Total') }}:</strong>
                                            </td>
                                            <td class="col-3 invoice-text-end">
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($order->total, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($order->total, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($order->discount > 0)
                                            <tr>
                                                <td class="col-3 invoice-text-end">
                                                    <strong>{{ __('Discount') }}:</strong></td>
                                                <td class="col-3 invoice-text-end">
                                                    @if (app()->getLocale() === 'ar')
                                                        -{{ number_format($order->discount, 2) }}
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                    @else
                                                        -{{ $order->currency->code ?? 'SAR' }}
                                                        {{ number_format($order->discount, 2) }}
                                                    @endif
                                                </td>
                                                <td class="col-3 invoice-text-end">
                                                    <strong>{{ __('Amount Paid') }}:</strong></td>
                                                <td class="col-3 invoice-text-end">
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                    @else
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="col-3 invoice-text-end"><strong>{{ __('VAT') }}:</strong>
                                            </td>
                                            <td class="col-3 invoice-text-end">
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($order->vat, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($order->vat, 2) }}
                                                @endif
                                            </td>
                                            <td class="col-3 invoice-text-end">
                                                <strong>{{ __('Amount Remaining') }}:</strong></td>
                                            <td class="col-3 invoice-text-end">
                                                @php
                                                    $remaining = ($order->total ?? 0) - ($order->amount_paid ?? 0);
                                                @endphp
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($remaining, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($remaining, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($order->other_taxes > 0)
                                            <tr>
                                                <td class="col-3 invoice-text-end">
                                                    <strong>{{ __('Other Taxes') }}:</strong></td>
                                                <td class="col-3 invoice-text-end">
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($order->other_taxes, 2) }}
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                    @else
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                        {{ number_format($order->other_taxes, 2) }}
                                                    @endif
                                                </td>
                                                <td class="col-3"></td>
                                                <td class="col-3"></td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>
                    <!-- Footer -->
                    <div class="invoice-text-start mt-4">
                        <div class="mt-3 policy-section invoice-text-start">

                            @if ($noteContent)
                                {!! $noteContent !!}
                            @endif
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="header">
        <header>
            <div class="row align-items-center gy-3">
                <div class="col-7 text-center invoice-text-start">
                    <img id="logo" class="w-25" src="{{ $logo }}" title="Koice" alt="Koice" />
                </div>
                <div class="col-5 text-center invoice-text-end">
                    <h4 class="text-7 mb-0">{{ __('Order') }}</h4>
                </div>
            </div>
            <hr>
        </header>
    </div>
    <div class="footer">
    </div>
</body>

</html>
