@extends('layouts.auth')

@push('styles')
<style>
    .btn-group {
        display: flex;
        justify-content: space-between;
    }

    .btn-brand {
        border-color: #004c35;
        color: #004c35;
        overflow: hidden;
    }

    .btn-danger {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn {
        display: inline-block;
        font-weight: 400;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border: 1px solid transparent;
        border-top-color: transparent;
        border-right-color: transparent;
        border-bottom-color: transparent;
        border-left-color: transparent;
        padding: .5rem .75rem;
        font-size: 1rem;
        line-height: 1.25;
        border-radius: .25rem;
        transition: all .15s ease-in-out;
        cursor: pointer;
    }

    .card {
        position: relative;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 1px solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }

    .card-body {
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 1.25rem;
    }

    .card-header:first-child {
        border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
    }

    .card-header {
        padding: .75rem 1.25rem;
        margin-bottom: 0;
        background-color: rgba(0, 0, 0, .03);
        border-bottom: 1px solid rgba(0, 0, 0, .125);
    }

    .mt {
        margin-top: 1rem;
    }
</style>
@endpush

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
            <p><strong>Deze applicatie kan vervolgens:</strong></p>
            <ul>
                @foreach ($scopes as $scope)
                <li>{{ $scope->description }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="btn-group mt">
            <form method="post" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button class="btn btn-danger">Weigeren</button>
            </form>

            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                @csrf

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <button type="submit" class="btn btn-brand">Toestaan en Inloggen</button>
            </form>
        </div>
    </div>
</div>
@endsection