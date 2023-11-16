@extends('layout')

@section('titre', 'Authentication - Login')

@section('content')
    <form action="" method="POST">
        @csrf
        <div class="field">
            <label class="label">Adresse e-mail</label>
            <div class="control">
                <input class="input" type="email" name="email" value="{{ old('email') }}">
            </div>
            @if($errors->has('email'))
                <p class="help is-danger">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="field">
            <div class="control">
                <button class="button is-link" type="submit">Envoyer</button>
            </div>
        </div>
    </form>
@endsection

