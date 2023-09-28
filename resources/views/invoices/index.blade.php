@extends('layout')

@section('titre', 'Invoice - Index')

@section('content')
    <h1 class="mb-5">Index</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID Client</th>
                <th scope="col">ID Commande</th>
                <th scope="col">Montant total</th>
                <th scope="col">Montant avant taxe</th>
                <th scope="col">Taxe</th>
                <th scope="col">Envoyé le</th>
                <th scope="col">Acquitté le</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->client_id }}</td>
                    <td>{{ $invoice->purchase_order_id }}</td>
                    <td>{{ $invoice->total_amount }} €</td>
                    <td>{{ $invoice->amount_before_tax }} €</td>
                    <td>{{ $invoice->tax }} %</td>
                    <td>{{ date('d/m/Y H:m:s', strtotime($invoice->send_at )) }}</td>
                    <td>{{ date('d/m/Y H:m:s', strtotime($invoice->acquitted_at  )) }}</td>
                    <td><a href="{{ route('invoices.show', ['invoice' => $invoice]) }}">Voir le détail</a></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No Invoices</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $invoices->withQueryString()->links() }}

@endsection
