@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<div class="btn-group">
			<button class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
			<a class="btn btn-success" href="/users/create"><i class="fa fa-plus"></i> Nieuw</a>
		</div>

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>.</th>
					<th>ID</th>
					<th>Naam</th>
					<th>Groepen</th>
					<th>Acties</th>
				</tr>
			</thead>
			<tbody>
				@foreach($users as $user)
					<tr>
						<td></td>
						<td>{{ $user->id }}</td>
						<td>{{ $user->name }}</td>
						<td>{{ $user->groups->first()->name }}, ...</td>
						<td><a href="/users/{{ $user->id }}/edit">bewerken</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection