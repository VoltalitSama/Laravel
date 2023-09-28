@extends('layout')
@section('titre', 'Tools - Index')

@section('content')
    <h1 class="mb-5">Index</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nom</th>
                <th scope="col">Description</th>
                <th scope="col">Prix</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tools as $tool)
                <tr>
                    <td>{{ $tool->name }}</td>
                    <td>{{ $tool->description }}</td>
                    <td>{{ $tool->price }} €</td>
                    <td><a href="{{ route('tools.show', ['tool' => $tool]) }}">Voir le détail</a></td>
                </tr>
            @empty
                <tr>
                    <td>No Tools</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
