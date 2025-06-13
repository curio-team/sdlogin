@extends('layouts.auth')

@section('content')
    <p>
        Log-in met je i-account:
    </p>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="id" class="label">i-nummer</label>
            <input placeholder="i123456" class="input" id="id" name="id" value="{{ old('id') }}" type="text" autofocus>
            @if ($errors->has('id'))
                <p class="help-block">{{ $errors->first('id') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="password" class="label">Wachtwoord</label>
            <input placeholder="Wachtwoord" class="input" id="password" name="password" type="password">
            @if ($errors->has('email'))
                <p class="help-block">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="form-group">
            <label for="remember" class="checkbox-wrapper">
                <input type="checkbox" class="checkbox" name="remember" id="remember">
                <span class="checkmark"></span>
                <span class="checkbox-label">Onthoud mij</span>
            </label>
        </div>

        <div class="form-group submit">
            <input type="submit" value="Inloggen" class="button">
            <a href="{{ route('password.request') }}">Wachtwoord vergeten &gt;</a>
        </div>
    </form>
@endsection
