@extends('layouts.app')

@section('content')

	<div class="container spaced-container glassy full-edge">
        <div>
            <h5>Groepslogins opvragen <strong>{{ $group->name }}</strong></h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <p><strong>Let op:</strong> je gaat van <em>alle</em> studenten in deze klas het wachtwoord resetten.
                <br />Hierna krijg je een afdrukbare pagina met alle accounts en wachtwoorden.</p>

            <form action="/grouplogin/{{ $group->id }}" method="POST">
                @csrf
                <button type="submit" class="button button-warning button-big"><i class="fa fa-refresh"></i> Wachtwoorden resetten</button>
            </form>
        </div>
    </div>

@endsection
