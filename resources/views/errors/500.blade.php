@extends('errors::minimal')

@section('title', 'Server fout')
@section('code', '500')

@section('message')

<div>
    Oeps, door een fout in onze applicatie kan deze pagina niet worden weergegeven.
</div>

<div>
    Sorry voor het ongemak.
</div>

@endsection
