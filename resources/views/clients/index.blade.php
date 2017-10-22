@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<a class="btn btn-success" href="/clients/create"><i class="fa fa-plus"></i> Nieuw</a>

		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>Naam</th>
					<th>URL</th>
					<th>Eigenaar</th>
					<th>Acties</th>
				</tr>
			</thead>
			<tbody>
				@foreach($clients as $client)
					<tr>
						<td>{{ $client->id }}</td>
						<td>{{ $client->name }}</td>
						<td>{{ $client->redirect }}</td>
						<td>{{ $client->user_id }}</td>
						<td>
							<div class="btn-group">
								<a class="btn btn-secondary" href="/clients/{{ $client->id }}"><i class="fa fa-eye"></i></a>
								<a class="btn btn-danger" href="/clients/{{ $client->id }}/delete"><i class="fa fa-trash"></i></a>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

@endsection