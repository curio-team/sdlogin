@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <h3>Weet je het zeker?</h3>

            <h5>Je gaat <strong>{{ $user->id }}</strong> ({{ $user->name }}) verwijderen.</h5>

            <form action="{{ route('users.destroy') }}" method="POST">
                @method('DELETE')
                @csrf
                <input type="hidden" name="delete[]" value="{{ $user->id }}">

                <button type="submit" class="button button-danger">
                    <i class="fa fa-trash"></i> Ga door met verwijderen
                </button>
            </form>
        </div>
    </div>

@endsection
