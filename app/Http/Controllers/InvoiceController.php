<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\InvoiceRequest;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function store(InvoiceRequest $request)
    {
        $user = Auth::user();
        $userId = $user->id;
        $userName = $user->name;

        $invoiceNumber = $this->generateInvoiceNumber($userName);

        $invoice = Invoice::create([
            'user_id' => $userId,
            'invoice_number' => $invoiceNumber,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
        ]);

        $carts = Cart::where('user_id', $userId)->get();
        foreach ($carts as $cart) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_id' => $cart->item_id,
                'quantity' => $cart->quantity,
            ]);
            $cart->delete();
        }

        return $this->getInvoice($invoice->id);
    }

    public function listInvoice()
    {
        $userId = Auth::user()->id;
        $invoices = Invoice::where('user_id', $userId)->get();

        return view('list', compact('invoices'));
    }

    public function getInvoice($invoice_id)
    {
        $invoiceData = $this->prepareInvoiceData($invoice_id);
        return view('invoice', compact('invoiceData'));
    }

    public function exportPDF($invoice_id)
    {
        $invoiceData = $this->prepareInvoiceData($invoice_id);
        $file_name = $invoiceData['invoice_number'] . '.pdf';

        $pdf = Pdf::loadView('export', compact('invoiceData'));
        return $pdf->download($file_name);
    }

    private function prepareInvoiceData($invoice_id)
    {
        $invoice = Invoice::with('cart.item.category')->findOrFail($invoice_id);

        $totalPrice = 0;
        $items = $invoice->cart->map(function ($invoiceItem) use (&$totalPrice){
            $totalPrice += $invoiceItem->item->price * $invoiceItem->quantity;
            return [
                'name' => $invoiceItem->item->name,
                'category' => $invoiceItem->item->category->category_name,
                'quantity' => $invoiceItem->quantity,
                'price' => $invoiceItem->item->price,
            ];
        });

        return [
            'invoice_id' => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'items' => $items,
            'total_price' => $totalPrice,
        ];
    }

    private function generateInvoiceNumber($userName)
    {
        $prefix = strtoupper(substr($userName, 0, 3));
        return $prefix . '-' . date('YmdHis');
    }
}
