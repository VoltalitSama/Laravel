<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class SearchInvoice extends Controller
{
    public function search(Request $request)
    {
        $email = $request->query('email');
        $price_higher_than = $request->query('price_higher_than');
        $price_lower_than = $request->query('price_lower_than');

        $invoices = Invoice::query()
            ->with(['client', 'tools'])
            ->withCount('tools')
            ->whereHas('client', function (Builder $query) use ($email) {
                if ($email) {
                    $query->where('email', $email);
                }
            })
            ->whereHas('tools', function (Builder $query) use ($price_higher_than) {
                if ($price_higher_than) {
                    $query->wherePriceGreaterThan((int)$price_higher_than);
                }
            });
        if ($price_lower_than) {
            $invoices->where('total_amount', '<', $price_lower_than);
        }


        $invoices = $invoices->get();

        foreach ($invoices as $invoice) {
            $total_amount = 0;

            foreach ($invoice->tools as $tool) {
                $total_amount += $tool->pivot->quantity * $tool->price->getPrice();
            }

            $invoice->my_total_amount = $total_amount;
        }

        //dd($invoices);

        return view('searchs/search', compact('invoices'));
    }
}
