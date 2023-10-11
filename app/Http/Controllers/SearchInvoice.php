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
            ->with('client')
            ->withCount('tools')
            ->whereHas('client', function (Builder $query) use ($email) {
                if ($email) {
                    $query->where('email', $email);
                }
            });
        if ($price_higher_than) {
                $invoices->where('total_amount', '>', $price_higher_than);
            }

        if ($price_lower_than) {
            $invoices->where('total_amount', '<', $price_lower_than);
        }

        $invoices = $invoices->get();

        return view('searchs/search', compact('invoices'));
    }
}
