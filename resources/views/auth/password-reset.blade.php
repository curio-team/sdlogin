@extends('layouts.auth')

@section('content')
    @if (session('status'))
        <p class="success-block">
            {{ session('status') }}
        </p>
    @endif

	<div>
        <strong>Vraag je docent om je wachtwoord te resetten.</strong>
        Zij kunnen je een nieuw tijdelijk wachtwoord geven.
        Verander dit wachtwoord direct na het inloggen.
	</div>
@endsection
