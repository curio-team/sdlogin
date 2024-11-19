@extends('layouts.app')

@section('content')

	<div class="container spaced-container">

		<h3>Weet je het zeker?</h3>

		<h5>Je gaat deze link verwijderen:</h5>
		<p>curio.codes/{{ $link->short }} <strong><i class="fa fa-long-arrow-right"></i></strong> {{ $link->url }}</p>

		<form action="{{ route('links.destroy') }}" method="POST">
			@method('DELETE')
			@csrf
			<input type="hidden" name="delete[]" value="{{ $link->id }}">

			<button type="submit" class="btn btn-danger">
				<i class="fa fa-trash"></i> Ga door met verwijderen
			</button>
		</form>

	</div>

@endsection
