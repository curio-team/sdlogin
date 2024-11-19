@extends('layouts.app')

@section('content')

	<div class="container spaced-container">

		<h3>Weet je het zeker?</h3>

		<h5>Je gaat <strong>{{ $user->id }}</strong> ({{ $user->name }}) verwijderen.</h5>

		<form action="{{ route('users.destroy') }}" method="POST">
			@method('DELETE')
			@csrf
			<input type="hidden" name="delete[]" value="{{ $user->id }}">

			<button type="submit" class="btn btn-danger">
				<i class="fa fa-trash"></i> Ga door met verwijderen
			</button>
		</form>

	</div>

@endsection
