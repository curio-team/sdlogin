@extends('layouts.app')

@section('content')

	<div class="container spaced-container">

		<h3>Weet je het zeker?</h3>

		<h5>Je gaat <strong>{{ $group->name }}</strong> ({{ $group->date_start }} - {{ $group->date_end }}) verwijderen.</h5>

		<form action="{{ route('groups.destroy', $group) }}" method="POST">
            @method('DELETE')
			@csrf
			<input type="hidden" name="delete[]" value="{{ $group->id }}">

			<button type="submit" class="btn btn-danger">
				<i class="fa fa-trash"></i> Ga door met verwijderen
			</button>
		</form>

	</div>

@endsection
