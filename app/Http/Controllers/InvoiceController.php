<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->create50();

        $order = $request->query('order', 'asc');
        if($order != 'asc' && $order != 'desc') {
            abort(403, "Mauvais paramètre");
        }

        $invoices = Invoice::query()
            ->orderBy('total_amount', $order)
            ->simplePaginate(10);

        return view('invoices/index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        return view('invoices/show', [
            'invoice' => $invoice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function create50()
    {
        $invoices = Invoice::query();

        // Vide la table
        $invoices->truncate();

        //$invoice = new Invoice();
        //$invoice->client_id = 2;
        //$invoice->save();

        // Crée les données
        for ($i = 1; $i <= 50; $i++) {
            $invoices->create([
                'client_id' => $i,
                'purchase_order_id' => $i,
                'total_amount' => $i * 1.1,
                'amount_before_tax' => $i,
                'tax' => 10,
            ]);
        }
    }
}
