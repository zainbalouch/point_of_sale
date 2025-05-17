@php
    if (app()->getLocale() == 'ar') {
       $isArabic = true;
    } else {
       $isArabic = false;
    }

@endphp
<html lang="{{ app()->getLocale() }}" dir="{{ $isArabic ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Stylesheet
======================= -->
    @if (app()->getLocale() == 'ar')
        <link href="/assets/css/bootstrap.rtl.min.css" rel="stylesheet">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.css') }}">
    @endif
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/invoice.css') }}" />
    @if ($isArabic)
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

    <!-- Print Styles for Header on Each Page -->
    <style>
        @media print {
            @if ($isArabic)
                @page {
                    size: auto;
                    margin: 10mm 4mm 10mm 4mm;
                }
            @else
                @page {
                    size: auto;
                    margin: 10mm 16mm 10mm 16mm;
                }
            @endif


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
            height: 200px;
        }

        .header {
            min-width: 728px;
            position: fixed;
            top: 5px;
        }

        .footer {
            min-width: 728px;
            position: fixed;
            bottom: 0;
        }

        .mainTable {
            min-width: 728px;
        }

        .logo {
            width: auto;
            height: auto;
            margin: 10px;
            max-height: 85px;
            max-width: 100px;
        }

        /* Darker table borders */
        .table {
            border-color: #000;
            border-width: 0.5px;
        }

        .table td,
        .table th {
            border-color: #000;
            border-width: 0.5px;
        }

        .mt-3.policy-section.invoice-text-start p,
        .mt-3.policy-section.invoice-text-start h3 {
            line-height: 1.4;
            text-align: justify;
            /* You can adjust this value as needed */
        }
    </style>
</head>

<body>
    <table class="mainTable">
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
                                                {{ number_format($item->discount ?? 0, 2) }}
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
                                <div class="table-responsive border-top-0">
                                    <table class="table border-top-0 mb-0">
                                        <tr class="border-top-0">
                                            <td class="col-3 invoice-text-end border-top-0">
                                                <strong>{{ __('Subtotal') }}:</strong>
                                            </td>
                                            <td class="col-3 invoice-text-end border-top-0">
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($order->subtotal, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($order->subtotal, 2) }}
                                                @endif
                                            </td>
                                            <td class="col-3 invoice-text-end border-top-0">
                                                <strong>{{ __('Total') }}:</strong>
                                            </td>
                                            <td class="col-3 invoice-text-end border-top-0">
                                                @if (app()->getLocale() === 'ar')
                                                    {{ number_format($order->total, 2) }}
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                @else
                                                    {{ $order->currency->code ?? 'SAR' }}
                                                    {{ number_format($order->total, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                        @if ($order->discount_totals > 0)
                                            <tr>
                                                <td class="col-3 invoice-text-end">
                                                    <strong>{{ __('Discount') }}:</strong>
                                                </td>
                                                <td class="col-3 invoice-text-end">
                                                    @if (app()->getLocale() === 'ar')
                                                        -{{ number_format($order->discount_totals, 2) }}
                                                        {{ $order->currency->code ?? 'SAR' }}
                                                    @else
                                                        -{{ $order->currency->code ?? 'SAR' }}
                                                        {{ number_format($order->discount_totals, 2) }}
                                                    @endif
                                                </td>
                                                <td class="col-3 invoice-text-end">
                                                    <strong>{{ __('Amount Paid') }}:</strong>
                                                </td>
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
                                                <strong>{{ __('Amount Remaining') }}:</strong>
                                            </td>
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
                                                    <strong>{{ __('Other Taxes') }}:</strong>
                                                </td>
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
            <div class="row justify-content-between position-absolute top-0 px-0 start-0 margin-auto">
                <div class="col-5">
                    <div class=""> <strong>{{ __('Invoiced To') }}:</strong>
                        <address>
                            @if ($order->customer)
                                {{ $order->customer->full_name }}<br />
                                @if ($order->customer->address)
                                    {{ $order->customer->address }}<br />
                                @endif
                                {{ $order->customer->phone_number }} <br>
                                @if ($order->customer->vat_number)
                                    {{ $order->customer->vat_number }}<br />
                                @endif
                            @else
                                {{ $order->customer_name ?? 'N/A' }}<br />
                                {{ $order->customer_phone_number ?? '' }}
                            @endif
                        </address>
                    </div>
                </div>
                <div class="col-2">
                    <div class="w-100 d-flex justify-content-center">
                        <img id="logo" class="logo rounded" src="{{ asset('storage/' . $logo) }}"
                            title="Koice" alt="Koice" />
                    </div>
                    <p class="text-center mt-1 fw-bold">{{ __('Taxable Order') }}</p>
                </div>
                <div class="col-5 {{ $isArabic ? 'pe-0' : '' }} invoice-text-end"> <strong>{{ __('Invoice No') }}:</strong>
                    {{ $order->number }}
                    <br>
                    <strong>{{ __('Date') }}:</strong>
                    @if ($isArabic)
                        {{ isset($order->issue_date) ? $order->issue_date : $order->created_at->format('Y/m/d') }}
                    @else
                        {{ isset($order->issue_date) ? $order->issue_date : $order->created_at->format('d/m/Y') }}
                    @endif
                    <br>
                    <div>
                        <strong>{{ __('Pay To') }}:</strong>

                        <address>
                            @if ($order->pointOfSale)
                                {{ $order->pointOfSale->{'name_' . app()->getLocale()} }}<br />
                            @endif
                            @if (isset($order->company->address) && $order->company->address != '')
                                {{ $order->company->address }}<br />
                            @endif
                            {{ $order->company->email }} <br>
                            {{ $order->company->tax_number }}
                        </address>
                    </div>
                </div>
            </div>
        </header>
    </div>
    <div class="footer">
    </div>
</body>
<script>
    // Set filename when printing
    window.onbeforeprint = function() {
        document.title = "{{ $order->number }}";
    };

    // Reset title after printing
    window.onafterprint = function() {
        document.title = "{{ config('app.name') }}";
    };

    // Reset title after printing and close page on mobile
    // window.onafterprint = function() {
    //     document.title = "{{ config('app.name') }}";

    //     // Check if device is mobile
    //     if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    //         window.close();
    //     }
    // };


    // Open print preview after 1 second
    // window.onload = function() {
    //     setTimeout(function() {
    //         window.print();
    //     }, 1000);
    // };
</script>

</html>
