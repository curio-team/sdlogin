@extends('layouts.app')

@section('content')

	<div class="container spaced-container">

		<div class="row">
			<div class="col-lg-12">
				<div class="btn-group">
					<a class="btn btn-success" href="{{ route('clients.create') }}"><i class="fa fa-plus"></i> Nieuw</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<table class="table my-table table-striped table-hover">
					<thead>
						<tr>
							<th class="th5p">ID</th>
							<th class="th15p">Naam</th>
							<th class="th45p">URL</th>
							<th class="th20p">Eigenaar</th>
							<th class="th15p">Acties</th>
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
										<a class="btn btn-secondary" href="{{ route('clients.show', $client) }}"><i class="fa fa-eye"></i></a>
										<a class="btn btn-danger" href="{{ route('clients.delete', $client) }}"><i class="fa fa-trash"></i></a>
									</div>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>

@endsection
