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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/riyal_currancy.css') }}" />
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

            /* @if ($isArabic)
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
        */ .header-print {
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
            height: 195px;
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
            margin: 0px;
            max-height: 130px;
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
            border-style: dotted;
        }

        /* Add styles for outer border */
        .table {
            border: 2px solid #000 !important;
        }

        /* RTL specific styles */
        @if ($isArabic)
            .table td:first-child,
            .table th:first-child {
                border-right: 2px solid #000 !important;
            }

            .table td:last-child,
            .table th:last-child {
                border-left: 2px solid #000 !important;
            }
        @else
            .table td:first-child,
            .table th:first-child {
                border-left: 2px solid #000 !important;
            }

            .table td:last-child,
            .table th:last-child {
                border-right: 2px solid #000 !important;
            }
        @endif

        .table tr:first-child td,
        .table tr:first-child th {
            border-top: 2px solid #000 !important;
        }

        .table tr:last-child td,
        .table tr:last-child th {
            border-bottom: 2px solid #000 !important;
        }

        /* Special case for the totals table */
        .table.border-top-0 {
            border-top: none !important;
        }

        .table.border-top-0 tr:first-child td {
            border-top: none !important;
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
                <td class="align-middle">
                    <div class="header-space">&nbsp;</div>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="align-middle">
                    <main>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <td class="align-middle text-center col-4"><strong>{{ __('Products') }}</strong>
                                        </td>
                                        <td class="align-middle text-center col-1"><strong>{{ __('Quantity') }}</strong>
                                        </td>
                                        <td class="align-middle text-center col-2">
                                            <strong>{{ __('Unit Price') }}</strong></td>
                                        <td class="align-middle text-center col-1"><strong>{{ __('Discount') }}</strong>
                                        </td>
                                        <td class="align-middle text-center col-1"><strong>{{ __('VAT') }}</strong>
                                        </td>
                                        @if ($order->other_taxes > 0)
                                            <td class="align-middle text-center col-2">
                                                <strong>{{ __('Other Taxes') }}</strong></td>
                                        @endif
                                        <td class="align-middle text-center col-3">
                                            <strong>{{ __('Items Subtotal') }}</strong>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="p-1 align-middle text-center col-4">
                                                {{ $item->{'product_name_' . app()->getLocale()} }}
                                                @if (!empty($item->note))
                                                    <br><small class="text-muted">{{ $item->note }}</small>
                                                @endif
                                            </td>
                                            <td class="p-1 align-middle text-center col-1 text-center">
                                                {{ $item->quantity }}</td>
                                            <td class="p-1 align-middle text-center col-2 text-center">
                                                {{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="p-1 align-middle text-center col-1 text-center">
                                                {{ number_format($item->discount_amount ?? 0, 2) }}
                                            </td>
                                            <td class="p-1 align-middle text-center col-1 text-center">
                                                {{ number_format($item->vat_amount ?? 0, 2) }}
                                            </td>
                                            @if ($order->other_taxes > 0)
                                                <td class="p-1 align-middle text-center col-2 text-center">
                                                    {{ number_format($item->other_taxes_amount ?? 0, 2) }}
                                                </td>
                                            @endif
                                            <td class="p-1 align-middle text-center col-3">
                                                {{ number_format($item->total_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{-- @if ($type == 'invoice') --}}
                            <div class="row">
                                <div class="col-6 text-center d-flex align-items-center justify-content-center">
                                    @if (isset($qrCode))

                                    <div>
                                        <img src="{{ $qrCode }}" alt="{{ __('QR Code') }}" class="img-fluid"
                                            style="max-width: 200px;">
                                    </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    <div class="table-responsive border-top-0">
                                        <table class="table border-top-0 mb-0">
                                            <tr class="border-top-0">
                                                <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                    <strong>{{ __('Subtotal') }}:</strong>
                                                </td>
                                                <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                    @if ($isArabic)
                                                        {{ number_format($order->subtotal, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->subtotal, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($order->discount > 0)
                                                <tr>
                                                    <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                        <strong>{{ __('Discount') }}:</strong>
                                                    </td>
                                                    <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                        @if ($isArabic)
                                                            {{ number_format($order->discount, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($order->discount, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                    <strong>{{ __('VAT') }}:</strong></td>
                                                <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                    @if ($isArabic)
                                                        {{ number_format($order->vat, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->vat, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($order->other_taxes > 0)
                                                <tr>
                                                    <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                        <strong>{{ __('Other Taxes') }}:</strong>
                                                    </td>
                                                    <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                        @if ($isArabic)
                                                            {{ number_format($order->other_taxes, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($order->other_taxes, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                    <strong>{{ __('Total') }}:</strong></td>
                                                <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                    @if ($isArabic)
                                                        {{ number_format($order->total, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->total, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="p-2 col-7 text-end border-top-0 border-end-0">
                                                    <strong>{{ __('Amount Paid') }}:</strong>
                                                </td>
                                                <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                    @if ($isArabic)
                                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $remaining = ($order->total ?? 0) - ($order->amount_paid ?? 0);
                                            @endphp
                                            @if ($remaining > 0)
                                                <tr>
                                                    <td class="p-2 col-7 text-end border-end-0">
                                                        <strong>{{ __('Amount Remaining') }}:</strong>
                                                    </td>
                                                    <td class="p-2 col-5 align-middle text-start fw-bold col-6 border-top-0 border-start-0">
                                                        @if ($isArabic)
                                                            {{ number_format($remaining, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($remaining, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        {{-- @else
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive border-top-0">
                                        <table class="table border-top-0 mb-0">
                                            <tr class="border-top-0">
                                                <td class="align-middle text-center col-3 border-top-0">
                                                    <strong>{{ __('Subtotal') }}:</strong>
                                                </td>
                                                <td class="align-middle text-center col-3 border-top-0">
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($order->subtotal, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->subtotal, 2) }}
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center col-3 border-top-0">
                                                    <strong>{{ __('Total') }}:</strong>
                                                </td>
                                                <td class="align-middle text-center col-3 border-top-0">
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($order->total, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->total, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($order->discount_totals > 0)
                                                <tr>
                                                    <td class="align-middle text-center col-3">
                                                        <strong>{{ __('Discount') }}:</strong>
                                                    </td>
                                                    <td class="align-middle text-center col-3">
                                                        @if (app()->getLocale() === 'ar')
                                                            {{ number_format($order->discount_totals, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($order->discount_totals, 2) }}
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center col-3">
                                                        <strong>{{ __('Amount Paid') }}:</strong>
                                                    </td>
                                                    <td class="align-middle text-center col-3">
                                                        @if (app()->getLocale() === 'ar')
                                                            {{ number_format($order->amount_paid ?? 0, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($order->amount_paid ?? 0, 2) }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="align-middle text-center col-3">
                                                    <strong>{{ __('VAT') }}:</strong>
                                                </td>
                                                <td class="align-middle text-center col-3">
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($order->vat, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($order->vat, 2) }}
                                                    @endif
                                                </td>
                                                <td class="align-middle text-center col-3">
                                                    <strong>{{ __('Amount Remaining') }}:</strong>
                                                </td>
                                                <td class="align-middle text-center col-3">
                                                    @php
                                                        $remaining = ($order->total ?? 0) - ($order->amount_paid ?? 0);
                                                    @endphp
                                                    @if (app()->getLocale() === 'ar')
                                                        {{ number_format($remaining, 2) }}
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                    @else
                                                        {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        {{ number_format($remaining, 2) }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($order->other_taxes > 0)
                                                <tr>
                                                    <td class="align-middle text-center col-3">
                                                        <strong>{{ __('Other Taxes') }}:</strong>
                                                    </td>
                                                    <td class="align-middle text-center col-3">
                                                        @if (app()->getLocale() === 'ar')
                                                            {{ number_format($order->other_taxes, 2) }}
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                        @else
                                                            {!! isset($order->currency->code) && $order->currency->code == 'SAR' ? '<span class="icon-saudi_riyal"></span>' : ($order->currency->code ?? '<span class="icon-saudi_riyal"></span>') !!}
                                                            {{ number_format($order->other_taxes, 2) }}
                                                        @endif
                                                    </td>
                                                    <td class="align-middle text-center col-3"></td>
                                                    <td class="align-middle text-center col-3"></td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif --}}
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
                <td class="align-middle">
                    <div class="footer-space">&nbsp;</div>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="header">
        <div class="row w-100 mx-0 px-0 justify-content-between position-absolute top-0 px-0 start-0 margin-auto">
            <div class="col-5">
                <strong>{{ $order->number }}</strong>
                <br>
                <strong>{{ __('Date') }}:</strong>
                @if ($isArabic)
                    {{ isset($order->issue_date) ? ($type == 'invoice' ? $order->issue_date->format('Y/m/d') : $order->issue_date) : $order->created_at->format('Y/m/d') }}
                @else
                    {{ isset($order->issue_date) ? ($type == 'invoice' ? $order->issue_date->format('d/m/Y') : $order->issue_date) : $order->created_at->format('d/m/Y') }}
                @endif
                <br>
                <div class=""> <strong>{{ $type == 'invoice' ? __('Invoiced To') : __('Ordered To') }}:</strong> <br>
                    @if ($order->customer)
                        <strong>{{ __('Name') }} : </strong>{{ $order->customer->full_name }}<br />
                        @if ($order->customer->vat_number && isset($show_customer_vat) && $show_customer_vat)
                            <strong>{{ __('VAT') }} : </strong>{{ $order->customer->vat_number }}<br />
                        @endif
                        @if ($order->customer->address && isset($show_customer_address) && $show_customer_address)
                            <strong>{{ __('Address') }} : </strong>{{ $order->customer->address }}<br />
                        @endif
                        @if ($order->customer->phone_number && isset($show_customer_phone_number) && $show_customer_phone_number)
                            <strong>{{ __('Phone') }} : </strong>{{ $order->customer->phone_number }} <br>
                        @endif
                    @else
                        <strong>{{ __('Name') }} : </strong>{{ $order->customer_name ?? 'N/A' }}<br />
                        @if ($order->customer_phone_number && isset($show_customer_phone_number) && $show_customer_phone_number)
                            <strong>{{ __('Phone') }} : </strong>{{ $order->customer_phone_number }}
                        @endif
                    @endif
                </div>
            </div>
            <div class="col-2">
                <div class="w-100 d-flex justify-content-center">
                    <img id="logo" class="logo rounded" src="{{ asset('storage/' . $logo) }}" title="Koice"
                        alt="Koice" />
                </div>
                <p class="text-center mt-0 fw-bold">{{ $invoice_title }}</p>
            </div>
            <div class="col-5 {{ $isArabic ? 'pe-0' : '' }} text-start ps-5">
                {{-- <strong>{{ __('Invoice No') }}:</strong> --}}

                <div class="ps-4">
                    {{-- <strong>{{ __('Pay To') }}:</strong> --}}

                    <address>
                        @if ($order->pointOfSale)
                            <strong>{{ __('Company') }} : </strong>{{ $order->company->legal_name }}<br />
                        @endif
                        @if ($order->company->tax_number && isset($show_company_vat) && $show_company_vat)
                            <strong>{{ __('VAT') }} : </strong>{{ $order->company->tax_number }} <br>
                        @endif
                        @if (isset($order->company->address) && $order->company->address != '' && isset($show_company_address) && $show_company_address)
                            <strong>{{ __('Address') }} : </strong>{{ $order->company->address }}<br />
                        @endif
                        @if ($order->company->email && isset($show_company_email) && $show_company_email)
                            <strong>{{ __('Email') }} : </strong>{{ $order->company->email }} <br>
                        @endif
                        @if ($order->company->phone_number && isset($show_company_phone_number) && $show_company_phone_number)
                            <strong>{{ __('Phone') }} : </strong>{{ $order->company->phone_number }} <br>
                        @endif
                    </address>
                </div>
            </div>
        </div>
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
