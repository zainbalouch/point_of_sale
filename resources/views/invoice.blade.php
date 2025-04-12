<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background-color: #f8f9fa;
        }

        .totals {
            float: right;
            width: 300px;
        }

        .totals table {
            width: 100%;
        }

        .totals table td {
            padding: 5px;
        }

        .totals table td:last-child {
            text-align: right;
        }

        .qr-code {
            text-align: center;
            margin-top: 30px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }

        @media print {
            body {
                padding: 0;
            }

            @page {
                margin: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h1>فاتورة مبيعات</h1>
        <h2>Sales Invoice</h2>
    </div>

    <div class="invoice-details">
        <table width="100%">
            <tr>
                <td>
                    <strong>Invoice #:</strong> {{ $order->number }}<br>
                    <strong>Date:</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                    <strong>VAT No:</strong> {{ $order->customer->vat_number ?? 'N/A' }}
                </td>
                <td style="text-align: right">
                    <strong>Customer:</strong> {{ $order->customer->first_name }} {{ $order->customer->last_name }}<br>
                    <strong>Phone:</strong> {{ $order->customer->phone_number }}<br>
                    <strong>Address:</strong> {{ $order->billingAddress->street ?? 'N/A' }}
                </td>
            </tr>
        </table>
    </div>

    <table class="invoice-table">
        <thead>
            <tr>
                <th>Item</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>VAT</th>
                <th>Other Taxes</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_name_en }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} {{ $order->currency->symbol }}</td>
                    <td>{{ number_format($item->vat_amount, 2) }} {{ $order->currency->symbol }}</td>
                    <td>{{ number_format($item->other_taxes_amount, 2) }} {{ $order->currency->symbol }}</td>
                    <td>{{ number_format($item->total_price, 2) }} {{ $order->currency->symbol }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td><strong>Subtotal:</strong></td>
                <td>{{ number_format($order->subtotal, 2) }} {{ $order->currency->symbol }}</td>
            </tr>
            <tr>
                <td><strong>VAT (15%):</strong></td>
                <td>{{ number_format($order->vat, 2) }} {{ $order->currency->symbol }}</td>
            </tr>
            <tr>
                <td><strong>Other Taxes:</strong></td>
                <td>{{ number_format($order->other_taxes, 2) }} {{ $order->currency->symbol }}</td>
            </tr>
            <tr>
                <td><strong>Discount:</strong></td>
                <td>{{ number_format($order->discount, 2) }} {{ $order->currency->symbol }}</td>
            </tr>
            <tr>
                <td><strong>Total:</strong></td>
                <td><strong>{{ number_format($order->total, 2) }} {{ $order->currency->symbol }}</strong></td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

    <div class="qr-code">
        <img src="{{$qrCode}}" alt="QR Code">
    </div>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This is a computer generated invoice and does not require a signature.</p>
    </div>
</body>

</html>
