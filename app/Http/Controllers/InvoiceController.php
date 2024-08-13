<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Counter;
use App\Models\InvoiceItem;

class InvoiceController extends Controller
{

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function getInvoices()
    {
        $invoices = Invoice::with('customer')->get();

        return response()->json([
            'invoices' =>$invoices,
        ], 200);
    }

    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function searchInvoice(Request $request)
    {
        $search = $request->get('s');

        if ($search != null) {
            $invoices = Invoice::with('customer')->where('id', 'LIKE', "%$search%")->get();
            return response()->json([
                'invoices' =>$invoices,
            ], 200);
        } else {
            return $this->getInvoices();
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $counter = Counter::where('key', 'invoice')->first();
        $ranndom = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();

        if($invoice) {
            $invoice = $invoice->id + 1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData = [
            'invoice_number' => $counter->prefix.$counters,
            'customer_id' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'terms_conditions' => 'Defaults',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => 0,
                    'quantity' => 1
                ]
            ]
        ];

        return response()->json($formData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoicedata['invoice_number'] = $request->input('invoice_number');
        $invoicedata['customer_id'] = $request->input('customer_id');
        $invoicedata['invoice_date'] = $request->input('date');
        $invoicedata['due_date'] = $request->input('due_date');
        $invoicedata['reference'] = $request->input('reference');
        $invoicedata['terms_conditions'] = $request->input('terms_conditions');
        $invoicedata['sub_total'] = $request->input('subtotal');
        $invoicedata['discount'] = $request->input('discount');
        $invoicedata['total'] = $request->input('total');

        $invoice =  Invoice::create($invoicedata);


        $invoiceItem = $request->input('invoice_item');

        foreach(json_decode($invoiceItem) as $item){
            $itemdata['product_id'] = $item->id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice = Invoice::with(['customer', 'invoiceItems.product'])->find($invoice->id);

        return response()->json([
            'invoice' =>$invoice,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function deleteItem(InvoiceItem $invoiceItem)
    {
        $invoiceItem = InvoiceItem::findOrFail($invoiceItem->id);

        $invoiceItem->delete();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $invoice->invoice_number = $request->invoice_number;

        $invoice->invoice_date = $request->date;

        $invoice->due_date = $request->due_date;

        $invoice->reference = $request->reference;

        $invoice->terms_conditions = $request->terms_conditions;

        $invoice->sub_total = $request->subtotal;

        $invoice->discount = $request->discount;

        $invoice->total = $request->total;

        $invoice->save();


        $invoiceItem = $request->input('invoice_item');


        $invoice->invoiceItems()->delete();

        foreach(json_decode($invoiceItem) as $item){
            $itemdata['product_id'] = $item->product_id;
            $itemdata['invoice_id'] = $invoice->id;
            $itemdata['quantity'] = $item->quantity;
            $itemdata['unit_price'] = $item->unit_price;

            InvoiceItem::create($itemdata);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice = Invoice::findOrFail($invoice->id);
        $invoice->invoiceItems()->delete();
        $invoice->delete();
    }
}
