@extends('layouts.auth')

@section('content')
    <p>
        Log-in met je i-account:
        <br/><span class="text-muted">Gestart voor 2020? Gebruik je D-nummer</span>
    </p>
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="form-group">
            <input placeholder="i123456" name="id" value="{{ old('id') }}" type="text">
            @if ($errors->has('id'))
                <p class="help-block">{{ $errors->first('id') }}</p>
            @endif
        </div>
        <div class="form-group">
            <input placeholder="Wachtwoord" name="password" type="password">
            @if ($errors->has('email'))
                <p class="help-block">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember"> <span>Onthoud mij</span>
            </label>
        </div>
        <div class="form-group submit">
            <input type="submit" value="Inloggen">
            <a href="{{ route('password.request') }}">Reset wachtwoord &gt;</a>
        </div>
    </form>
@endsection