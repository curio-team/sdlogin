@extends('layouts.auth')

@section('content')
    @if (session('status'))
        <p class="success-block">
            {{ session('status') }}
        </p>
    @endif

	<div class="alert alert-danger">
        <strong>Let op!</strong>
		<div>Vanwege beperkingen in de mailserver van Curio is het hoogstwaarschijnlijk dat je de 'wachtwoord vergeten'-mail niet ontvangt. Dit is omdat er 'curio' in de afzender voorkomt en Curio 'phishing'-aanvallen wil voorkomen.</div>
        <strong>Vraag daarom je docent om je wachtwoord voor je te resetten.</strong>
	</div>

    <p>Reset je wachtwoord:</p>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

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
