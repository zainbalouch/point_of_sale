<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="images/favicon.png" rel="icon" />
    <title>{{ $order->company->name }} - {{ __('Invoice') }}</title>
    <meta name="author" content="harnishdesign.net">

    <!-- Web Fonts
======================= -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900'
        type='text/css'>

    <!-- Stylesheet
======================= -->
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
</head>

<body>
    <!-- Container -->
    <div class="container-fluid invoice-container">
        <!-- Header -->
        <header>
            <div class="row align-items-center gy-3">
                <div class="col-7 text-center invoice-text-start">
                    <img id="logo" class="w-25" src="{{ asset('assets/images/estilo_logo.png') }}" title="Koice"
                        alt="Koice" />
                </div>
                <div class="col-5 text-center invoice-text-end">
                    <h4 class="text-7 mb-0">{{ __('Invoice') }}</h4>
                </div>
            </div>
            <hr>
        </header>

        <!-- Main Content -->
        <main>
            <div class="row">
                <div class="col-6"><strong>{{ __('Date') }}:</strong>
                    @if (app()->getLocale() === 'ar')
                        {{ $order->created_at->format('Y/m/d') }}
                    @else
                        {{ $order->created_at->format('d/m/Y') }}
                    @endif
                </div>
                <div class="col-6 invoice-text-end"> <strong>{{ __('Invoice No') }}:</strong> {{ $order->number }}
                </div>

            </div>
            <hr>
            <div class="row">
                <div class="col-6 text-end order-1"> <strong>{{ __('Pay To') }}:</strong>
                    <address>
                        {{ $order->company->legal_name }}<br />
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
                            <td class="col-2 text-center"><strong>{{ __('VAT') }}</strong></td>
                            @if ($order->other_taxes > 0)
                                <td class="col-2 text-center"><strong>{{ __('Other Taxes') }}</strong></td>
                            @endif
                            <td class="col-2 invoice-text-end"><strong>{{ __('Items Subtotal') }}</strong></td>
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
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($item->unit_price, 2) }}
                                    @else
                                        {{ number_format($item->unit_price, 2) }}
                                    @endif
                                </td>
                                <td class="col-2 text-center">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($item->vat_amount ?? 0, 2) }}
                                    @else
                                        {{ number_format($item->vat_amount ?? 0, 2) }}
                                    @endif
                                </td>
                                @if ($order->other_taxes > 0)
                                    <td class="col-2 text-center">
                                        @if (app()->getLocale() === 'ar')
                                            {{ number_format($item->other_taxes_amount ?? 0, 2) }}
                                        @else
                                            {{ number_format($item->other_taxes_amount ?? 0, 2) }}
                                        @endif
                                    </td>
                                @endif
                                <td class="col-2 invoice-text-end">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($item->total_price, 2) }}
                                    @else
                                        {{ number_format($item->total_price, 2) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-6 text-center d-flex align-items-center justify-content-center">
                    <div>
                        <img src="{{ $qrCode }}" alt="{{ __('QR Code') }}" class="img-fluid"
                            style="max-width: 200px;">
                    </div>
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table border border-top-0 mb-0">
                            <tr>
                                <td class="invoice-text-end"><strong>{{ __('Subtotal') }}:</strong></td>
                                <td class="col-6 invoice-text-end">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($order->subtotal, 2) }} {{ $order->currency->code ?? 'SAR' }}
                                    @else
                                        {{ $order->currency->code ?? 'SAR' }} {{ number_format($order->subtotal, 2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="invoice-text-end"><strong>{{ __('VAT') }}:</strong></td>
                                <td class="col-6 invoice-text-end">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($order->vat, 2) }} {{ $order->currency->code ?? 'SAR' }}
                                    @else
                                        {{ $order->currency->code ?? 'SAR' }} {{ number_format($order->vat, 2) }}
                                    @endif
                                </td>
                            </tr>
                            @if ($order->other_taxes > 0)
                                <tr>
                                    <td class="invoice-text-end"><strong>{{ __('Other Taxes') }}:</strong></td>
                                    <td class="col-6 invoice-text-end">
                                        @if (app()->getLocale() === 'ar')
                                            {{ number_format($order->other_taxes, 2) }}
                                            {{ $order->currency->code ?? 'SAR' }}
                                        @else
                                            {{ $order->currency->code ?? 'SAR' }}
                                            {{ number_format($order->other_taxes, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            @if ($order->discount > 0)
                                <tr>
                                    <td class="invoice-text-end"><strong>{{ __('Discount') }}:</strong></td>
                                    <td class="col-6 invoice-text-end">
                                        @if (app()->getLocale() === 'ar')
                                            -{{ number_format($order->discount, 2) }}
                                            {{ $order->currency->code ?? 'SAR' }}
                                        @else
                                            -{{ $order->currency->code ?? 'SAR' }}
                                            {{ number_format($order->discount, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                            <tr>
                                <td class="invoice-text-end"><strong>{{ __('Total') }}:</strong></td>
                                <td class="col-6 invoice-text-end">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($order->total, 2) }} {{ $order->currency->code ?? 'SAR' }}
                                    @else
                                        {{ $order->currency->code ?? 'SAR' }} {{ number_format($order->total, 2) }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="invoice-text-end"><strong>{{ __('Amount Paid') }}:</strong></td>
                                <td class="col-6 invoice-text-end">
                                    @if (app()->getLocale() === 'ar')
                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                        {{ $order->currency->code ?? 'SAR' }}
                                    @else
                                        {{ $order->currency->code ?? 'SAR' }}
                                        {{ number_format($order->amount_paid ?? 0, 2) }}
                                    @endif
                                </td>
                            </tr>
                            @php
                                $remaining = ($order->total ?? 0) - ($order->amount_paid ?? 0);
                            @endphp
                            @if ($remaining > 0)
                                <tr>
                                    <td class="invoice-text-end"><strong>{{ __('Amount Remaining') }}:</strong></td>
                                    <td class="col-6 invoice-text-end">
                                        @if (app()->getLocale() === 'ar')
                                            {{ number_format($remaining, 2) }} {{ $order->currency->code ?? 'SAR' }}
                                        @else
                                            {{ $order->currency->code ?? 'SAR' }} {{ number_format($remaining, 2) }}
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <!-- Footer -->
        <footer class="invoice-text-start mt-4">
            <div class="mt-3 policy-section invoice-text-start">
                <p class="mb-2"><strong>{{ __('Payment, return and exchange policy') }}</strong></p>
                <p class="mb-1"><strong>{{ __('First: Ready-made pieces') }}</strong></p>
                <p class="text-1 mb-3">
                    {{ __('If the piece is received as it is without modifications or repairs, the full amount will be paid and the amount can be refunded within one day and replaced within 3 days, provided that the piece is in good condition. In the event of repairs or modifications to the piece, the full amount is paid, non-refundable and exchangeable.') }}
                </p>
                <p class="mb-1"><strong>{{ __('Second: Special design') }}</strong></p>
                <ol class="text-1">
                    <li>{{ __('50% of the design and implementation amount is paid as a non-refundable deposit after agreement and approval of the design.') }}</li>
                    <li>{{ __('The full amount is paid for the value of the fabrics before they are cut after agreement and approval. It is non-refundable.') }}</li>
                    <li>{{ __('The remaining 50% of the design and implementation value will be paid in addition to the resulting increases if any modifications are added to the design upon receipt of the piece.') }}</li>
                </ol>
            </div>
        </footer>
    </div>
</body>

</html>
