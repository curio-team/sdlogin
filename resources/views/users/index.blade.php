@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')
	
	<div class="container spaced-container">
		
		<form action="/users" method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<div class="btn-group">
				<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
				<a class="btn btn-success" href="/users/create"><i class="fa fa-plus"></i> Nieuw</a>
			</div>

			<table id="check-table" class="table my-table table-striped table-hover">
				<thead>
					<tr>
						<th class="th5p">&nbsp;</th>
						<th class="th15p">ID</th>
						<th class="th35p">Naam</th>
						<th class="th30p">Groepen</th>
						<th class="th15p">Acties</th>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
						<tr>
							<td><input type="checkbox" name="delete[]" value="{{ $user->id }}"></td>
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
		</form>
	</div>

@endsection