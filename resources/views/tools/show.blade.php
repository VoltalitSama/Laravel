@extends('layout')

@section('titre', 'Tools - Show')

@section('content')
    <div class="row align-item-center">
        <div class="col-6">
            <h1>Show</h1>
            <dl>
                <dt>ID</dt>
                <dd>{{ $tool->id }}</dd>

                <dt>Name</dt>
                <dd>{{ $tool->name }}</dd>

                <dt>Description</dt>
                <dd>{{ $tool->description }}</dd>

                <dt>Prix</dt>
                <dd>{{ $tool->price }} €</dd>

                <dt>Créé le</dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($tool->created_at)) }}</dd>

                <dt>Modifié le</dt>
                <dd>{{ date('d/m/Y H:m:s', strtotime($tool->updated_at)) }}</dd>
            </dl>

            <a href="{{ route('tools.index') }}">Revenir à l'accueil</a>
        </div>
    </div
@endsection
