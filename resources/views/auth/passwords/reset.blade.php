@extends('layouts.auth')

@section('content')
    <div class="alert alert-primary">
        Lees ook onze <a href="/passwords" target="_blank">richtlijnen</a> voor een sterk wachtwoord.
    </div>
	@if ($errors->any())
	<div class="alert alert-danger">
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
    <p>Reset je wachtwoord:</p>
    <form method="POST" action="{{ route('password.request') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="form-group">
            <p>E-mailadres</p>
            <input placeholder="D123456@edu.rocwb.nl" type="email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <p class="help-block">{{ $errors->first('email') }}</p>
            @endif
        </div>
        <div class="form-group">
            <p>Nieuw wachtwoord</p>
            <input type="password" name="password">
            @if ($errors->has('password'))
                <p class="help-block">{{ $errors->first('password') }}</p>
            @endif
        </div>
        <div class="form-group">
            <p>Bevestig wachtwoord</p>
            <input type="password" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <p class="help-block">{{ $errors->first('password_confirmation') }}</p>
            @endif
        </div>
        <div class="form-group submit">
            <input type="submit" value="Reset wachtwoord">
        </div>
    </form>
@endsection
