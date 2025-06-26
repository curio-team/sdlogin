@extends('layouts.auth')

@section('content')
<div class="card card-default">
    <div class="card-header">
        Inlogverzoek
    </div>
    <div class="card-body">
        <!-- Introduction -->
        <p><strong>{{ $client->name }}</strong> vraagt toestemming om in te loggen met jouw i-account.</p>
        <p class="mt"><em>De applicatie kan alleen jouw naam, klas en Curio-mailadres bekijken.</em></p>

        <!-- Scope List -->
        @if (count($scopes) > 0)
        <div class="scopes">
            <p><strong>Deze applicatie krijgt vervolgens:</strong></p>
            <ul class="pl-4">
                @foreach ($scopes as $scope)
                <li>{{ $scope->description }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="button-group mt">
            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                @csrf

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button type="submit" class="button button-big btn-danger">Toestaan en Inloggen</button>
            </form>

            <form method="post" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button class="button">Weigeren</button>
            </form>
        </div>
    </div>
</div>
@endsection
