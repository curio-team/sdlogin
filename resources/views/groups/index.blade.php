

@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')
	
	<div class="container spaced-container">

		@if (session('notice'))
		<div class="alert alert-success">
			{{ session('notice') }}
		</div>
		@endif
		
		<form action="/groups" method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<div class="btn-group">
				<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
				<a class="btn btn-success" href="/groups/create"><i class="fa fa-plus"></i> Nieuw</a>
			</div>

			<table id="check-table" class="table my-table table-striped table-hover">
				<thead>
					<tr>
						<th class="th5p">&nbsp;</th>
						<th class="th30p">Naam</th>
						<th class="th25p">Startdatum</th>
						<th class="th25p">Einddatum</th>
						<th class="th15p">Acties</th>
					</tr>
				</thead>
				<tbody>
					@foreach($groups as $group)
						<tr <?php echo $group->date_end < \Carbon\Carbon::now() ? 'class="historical"' : '';?>>
							<td><input type="checkbox" name="delete[]" value="{{ $group->id }}"></td>
							<td>{{ $group->name }}</td>
							<td>{{ $group->date_start }}</td>
							<td>{{ $group->date_end }}</td>
							<td>
								<div class="btn-group">
									<a class="btn btn-primary" href="/groups/{{ $group->id }}/edit"><i class="fa fa-pencil"></i></a>
									<a class="btn btn-danger" href="/groups/{{ $group->id }}/delete"><i class="fa fa-trash"></i></a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</form>
	</div>

@endsection