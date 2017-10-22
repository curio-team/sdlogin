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
						<td>
							@if($user->groups->count())
								{{ $user->groups->first()->name }}, ...
							@else
								(geen)
							@endif
						</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-primary" href="/users/{{ $user->id }}/edit"><i class="fa fa-pencil"></i></a>
								<a class="btn btn-danger" href="/users/{{ $user->id }}/delete"><i class="fa fa-trash"></i></a>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection