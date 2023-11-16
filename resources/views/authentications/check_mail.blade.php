@extends('layout')

@section('titre', 'Checkmail')

@section('content')
<div>
    <h1>Vérifiez vos mails !</h1>
    <p>Consultez votre boite mail à l'adresse suivante : {{ $user->email }}</p>
</div>
@endsection

