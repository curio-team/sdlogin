@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
	<script type="text/javascript" src="/js/filter.js"></script>
@endpush

@section('content')

	<div class="container spaced-container">

		@if (session('notice'))
		<div class="alert alert-success">
			{{ session('notice') }}
		</div>
		@endif

		<form action="/groups" method="POST">
			@method('DELETE')
			@csrf
			<div class="row">
				<div class="col-lg-6">
					<div class="btn-group">
						<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
						<a class="btn btn-primary" href="/groups/create/batch"><i class="fa fa-plus"></i> Batch</a>
						<a class="btn btn-success" href="/groups/create"><i class="fa fa-plus"></i> Nieuw</a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-inline justify-content-end">
						<select class="form-control" id="filter">
							<?php $f = request('f', 'current'); ?>
							<option value="all" {{ ($f == 'all') ? 'selected' : '' }}>Alles</option>
							<option value="current" {{ ($f == 'current') ? 'selected' : '' }}>Huidig</option>
							<option value="history" {{ ($f == 'history') ? 'selected' : '' }}>Geschiedenis</option>
							<option value="future" {{ ($f == 'future') ? 'selected' : '' }}>Toekomstig</option>
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
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
											<a class="btn btn-danger" href="{{ route('groups.delete', $group) }}"><i class="fa fa-trash"></i></a>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</div>

@endsection
