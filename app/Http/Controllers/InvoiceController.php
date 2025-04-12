<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Prgayman\Zatca\Facades\Zatca;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\{Seller, TaxNumber, InvoiceDate, InvoiceTotalAmount, InvoiceTaxAmount};


class InvoiceController extends Controller
{
    public function show(Order $order)
    {
        // Generate QR code with scanning URL
        $qrCode = GenerateQrCode::fromArray([
            new Seller($order->company->name), // seller name
            new TaxNumber($order->company->tax_number), // seller tax number
            new InvoiceDate($order->created_at), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($order->total), // invoice total amount
            new InvoiceTaxAmount($order->vat ?? 0) // invoice tax amount
            // .......
        ])->render();
        $pdf = PDF::loadView('invoice', ['order' => $order, 'qrCode' => $qrCode]);

        return $pdf->stream("invoice-{$order->number}.pdf");
    }

    public function publicAccess($orderNumber)
    {
        $order = Order::where('number', $orderNumber)->firstOrFail();

        // Generate PDF
        $pdf = PDF::loadView('invoice', ['order' => $order]);

        return $pdf->stream("invoice-{$order->number}.pdf");
    }

    /**
     * Display QR code for an order
     *
     * @param Order $order
     * @return \Illuminate\View\View
     */
    public function showQrCode(Order $order)
    {
        // Get company information from config or environment
        $companyName = config('app.name');
        $taxNumber = config('app.vat_number', '');

        // Generate QR code using Salla\ZATCA package with proper objects
        $qrCode = GenerateQrCode::fromArray([
            new Seller($companyName),
            new TaxNumber($taxNumber),
            new InvoiceDate(now()), // current time for the invoice
            new InvoiceTotalAmount($order->total),
            new InvoiceTaxAmount($order->vat ?? 0),
        ]);

        // Use render() to get the actual QR code image
        $qrCodeImage = $qrCode->render();

        return view('qr-code', [
            'order' => $order,
            'qrCode' => $qrCodeImage
        ]);
    }
}
