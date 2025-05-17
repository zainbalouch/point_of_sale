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
        $noteContent = InvoiceTemplateSetting::get('note', null, $order->company_id);

        $show_customer_email = InvoiceTemplateSetting::get('show_customer_email', null, $order->company_id);
        $show_customer_address = InvoiceTemplateSetting::get('show_customer_address', null, $order->company_id);
        $show_customer_phone_number = InvoiceTemplateSetting::get('show_customer_phone_number', null, $order->company_id);
        $show_customer_vat = InvoiceTemplateSetting::get('show_customer_vat', null, $order->company_id);
        $show_company_vat = InvoiceTemplateSetting::get('show_company_vat', null, $order->company_id);
        $show_company_email = InvoiceTemplateSetting::get('show_company_email', null, $order->company_id);
        $show_company_phone_number = InvoiceTemplateSetting::get('show_company_phone_number', null, $order->company_id);
        $show_company_address = InvoiceTemplateSetting::get('show_company_address', null, $order->company_id);
        $order_invoice_title = InvoiceTemplateSetting::get('order_invoice_title', null, $order->company_id);

        $logo = InvoiceTemplateSetting::get('logo', null, $order->company_id);
        $type = 'order_invoice';
        if (empty($logo)) {
            $logo = env('APP_URL') . '/assets/images/estilo_logo.png';
        }

        // Return view directly instead of PDF
        return view('invoice-template', ['order' => $order, 'noteContent' => $noteContent, 'logo' => $logo, 'show_customer_email' => $show_customer_email, 'show_customer_address' => $show_customer_address, 'show_customer_phone_number' => $show_customer_phone_number, 'show_customer_vat' => $show_customer_vat, 'show_company_vat' => $show_company_vat, 'show_company_email' => $show_company_email, 'show_company_address' => $show_company_address, 'show_company_phone_number' => $show_company_phone_number, 'invoice_title' => $order_invoice_title, 'type' => $type]);
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

        $show_customer_email = InvoiceTemplateSetting::get('show_customer_email', null, $invoice->company_id);
        $show_customer_address = InvoiceTemplateSetting::get('show_customer_address', null, $invoice->company_id);
        $show_customer_phone_number = InvoiceTemplateSetting::get('show_customer_phone_number', null, $invoice->company_id);
        $show_customer_vat = InvoiceTemplateSetting::get('show_customer_vat', null, $invoice->company_id);
        $show_company_vat = InvoiceTemplateSetting::get('show_company_vat', null, $invoice->company_id);
        $show_company_email = InvoiceTemplateSetting::get('show_company_email', null, $invoice->company_id);
        $show_company_phone_number = InvoiceTemplateSetting::get('show_company_phone_number', null, $invoice->company_id);
        $show_company_address = InvoiceTemplateSetting::get('show_company_address', null, $invoice->company_id);
        $invoice_title = InvoiceTemplateSetting::get('invoice_title', null, $invoice->company_id);
        $logo = InvoiceTemplateSetting::get('logo', null, $invoice->company_id);
        $type = 'invoice';
        if (empty($logo)) {
            $logo = env('APP_URL') . '/assets/images/estilo_logo.png';
        }
        $noteContent = InvoiceTemplateSetting::get('note', null, $invoice->company_id);
        // Return view directly instead of PDF
        return view('invoice-template', ['order' => $invoice, 'qrCode' => $qrCode, 'noteContent' => $noteContent, 'logo' => $logo, 'show_customer_email' => $show_customer_email, 'show_customer_address' => $show_customer_address, 'show_customer_phone_number' => $show_customer_phone_number, 'show_customer_vat' => $show_customer_vat, 'show_company_vat' => $show_company_vat, 'show_company_email' => $show_company_email, 'show_company_address' => $show_company_address, 'show_company_phone_number' => $show_company_phone_number, 'invoice_title' => $invoice_title, 'type' => $type]);
    }
}
