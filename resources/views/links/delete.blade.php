@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<h3>Weet je het zeker?</h3>

		<h5>Je gaat deze link verwijderen:</h5>
		<p>amo.rocks/{{ $link->short }} <strong>=&gt;</strong> {{ $link->url }}</p>
		
		<form action="/links" method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<input type="hidden" name="delete[]" value="{{ $link->id }}">

			<button type="submit" class="btn btn-danger">
				<i class="fa fa-trash"></i> Ga door met verwijderen
			</button>
		</form>

	</div>

@endsection