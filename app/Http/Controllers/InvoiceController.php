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
            new Seller($order->company->legal_name), // seller name
            new TaxNumber($order->company->tax_number), // seller tax number
            new InvoiceDate($order->created_at), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($order->total), // invoice total amount
            new InvoiceTaxAmount($order->vat ?? 0) // invoice tax amount
        ])->render();
        $noteSetting = \App\Models\InvoiceTemplateSetting::where('key_name', 'note')
            ->where('company_id', $order->company_id)
            ->first();

        $noteContent = $noteSetting['value_' . app()->getLocale()] ?? '';
        // Return view directly instead of PDF
        return view('invoice', ['order' => $order, 'qrCode' => $qrCode, 'noteContent' => $noteContent]);
    }
}
