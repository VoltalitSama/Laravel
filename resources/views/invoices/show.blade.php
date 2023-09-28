@extends('layout')

@section('titre', 'Invoice - Show')

@section('content')
    <div class="row align-item-center">
        <div class="col-6">
            <h1>Show</h1>
            <dl>
                <dt>ID</dt>
                <dd>{{ $invoice->id }}</dd>

                <dt>ID Client</dt>
                <dd>{{ $invoice->client_id }}</dd>

                <dt>ID Commande</dt>
                <dd>{{ $invoice->purchase_order_id }}</dd>

                <dt>Montant total</dt>
                <dd>{{ $invoice->total_amount }} €</dd>

                <dt>Montant avant taxe</dt>
                <dd>{{ $invoice->amount_before_tax }} €</dd>

                <dt>Taxe</dt>
                <dd>{{ $invoice->tax }} </dd>

                <dt>Envoyé le </dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($invoice->send_at)) }}</dd>

                <dt>Acquitté le</dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($invoice->acquitted_at)) }}</dd>

                <dt>Créé le</dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($invoice->created_at)) }}</dd>

                <dt>Modifié le</dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($invoice->updated_at)) }}</dd>
            </dl>

            <a href="{{ route('invoices.index') }}">Revenir à l'accueil</a>
        </div>
    </div
@endsection
