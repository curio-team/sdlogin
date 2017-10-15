@extends('layouts.auth')

@section('content')
    @if (session('status'))
        <p class="success-block">
            {{ session('status') }}
        </p>
    @endif
    
    <p>Reset je wachtwoord:</p>
    <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="form-group">
            <input placeholder="D123456@edu.rocwb.nl" type="email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <p class="help-block">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="form-group submit">
            <input type="submit" value="Stuur mij de reset-link">
        </div>
    </form>
@endsection
