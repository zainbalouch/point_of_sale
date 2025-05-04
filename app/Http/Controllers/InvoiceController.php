<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceTemplateSetting;
use App\Models\Order;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Prgayman\Zatca\Facades\Zatca;
use Salla\ZATCA\GenerateQrCode;
use Salla\ZATCA\Tags\{Seller, TaxNumber, InvoiceDate, InvoiceTotalAmount, InvoiceTaxAmount};


class InvoiceController extends Controller
{
    public function showOrderInvoice(Order $order)
    {
        $noteSetting = InvoiceTemplateSetting::where('key_name', 'note')
            ->where('company_id', $order->company_id)
            ->first();


        $logo = Setting::get('logo_dark');
        if (!empty($logo)) {
            $dom = new \DOMDocument();
            $dom->loadHTML($logo, LIBXML_NOERROR);
            $images = $dom->getElementsByTagName('img');
            if ($images->length > 0) {
                $logo = $images->item(0)->getAttribute('src');
            }
        } else {
            $logo = env('APP_URL') . '/assets/images/estilo_logo.png';
        }
        // Extract image URL from rich text content
        if (!empty($logo)) {
            $dom = new \DOMDocument();
            $dom->loadHTML($logo, LIBXML_NOERROR);
            $images = $dom->getElementsByTagName('img');
            if ($images->length > 0) {
                $logo = $images->item(0)->getAttribute('src');
            }
        }

        $noteContent = $noteSetting['value_' . app()->getLocale()] ?? '';
        // Return view directly instead of PDF
        return view('orderInvoice', ['order' => $order, 'noteContent' => $noteContent, 'logo' => $logo]);
    }


    public function showInvoice(Invoice $invoice)
    {
        // Generate QR code with scanning URL
        $qrCode = GenerateQrCode::fromArray([
            new Seller($invoice->company->legal_name), // seller name
            new TaxNumber($invoice->company->tax_number), // seller tax number
            new InvoiceDate($invoice->created_at), // invoice date as Zulu ISO8601 @see https://en.wikipedia.org/wiki/ISO_8601
            new InvoiceTotalAmount($invoice->total), // invoice total amount
            new InvoiceTaxAmount($invoice->vat ?? 0) // invoice tax amount
        ])->render();
        $noteSetting = InvoiceTemplateSetting::where('key_name', 'note')
            ->where('company_id', $invoice->company_id)
            ->first();
        $logo = Setting::get('logo_dark');
        // Extract image URL from rich text content
        if (!empty($logo)) {
            $dom = new \DOMDocument();
            $dom->loadHTML($logo, LIBXML_NOERROR);
            $images = $dom->getElementsByTagName('img');
            if ($images->length > 0) {
                $logo = $images->item(0)->getAttribute('src');
            }
        } else {
            $logo = env('APP_URL') . '/assets/images/estilo_logo.png';
        }

        $noteContent = $noteSetting['value_' . app()->getLocale()] ?? '';
        // Return view directly instead of PDF
        return view('invoice', ['order' => $invoice, 'qrCode' => $qrCode, 'noteContent' => $noteContent, 'logo' => $logo]);
    }
}
