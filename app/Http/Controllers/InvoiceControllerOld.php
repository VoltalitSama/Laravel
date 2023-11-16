<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;

class InvoiceControllerOld extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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

    public function createData()
    {
        $clients = Client::query();
        $clients->truncate();
        // Crée les données
        for ($i = 1; $i <= 3; $i++) {
            $client = Client::create([
                'email' => 'compte' . $i . '@mail.fr',
                'address' => 'rue' . $i,
            ]);
            $tools = [];
            for ($p = 1; $p <= 3; $p++) {
                $tool = Tool::create([
                    'name' => 'tool' . $i . $p,
                    'description' => 'tool numero' . $i . $p,
                    'price' => $i * $p * 1.1,
                ]);
                $tools[] = $tool->id;
            }
            for ($j = 1; $j <= 2; $j++) {
                $invoice = Invoice::create([
                    'client_id' => $client->id,
                    'purchase_order_id' => $j,
                    'total_amount' => $j * 1.1,
                    'amount_before_tax' => $j,
                    'tax' => 10,
                ]);
                foreach ($tools as $tool)
                    $invoice->tools()->attach($tool, ['quantity' => 2]);
            }
        }
    }
}
