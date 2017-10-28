@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
	<script type="text/javascript" src="/js/pagination.js"></script>
@endpush

@section('content')
	
	<div class="container spaced-container">

		@if (session('notice'))
		<div class="alert alert-success">
			{{ session('notice') }}
		</div>
		@endif
		
		<form action="/users" method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-lg-6">
					<div class="btn-group">
						<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
						<a class="btn btn-primary" href="/users/import"><i class="fa fa-upload"></i> Importeren</a>
						<a class="btn btn-success" href="/users/create"><i class="fa fa-plus"></i> Nieuw</a>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-inline justify-content-end">
						<div class="input-group mr-2">
							@if(request('q'))
								<span class="input-group-btn">
									<button type="button" id="search_clear" class="btn btn-secondary">x</button>
								</span>
							@endif
							<input type="text" id="search_text" class="form-control" value="{{ request('q') }}">
							<span class="input-group-btn">
								<button type="button" id="search_button" class="btn btn-secondary">Zoeken</button>
							</span>
						</div>
						
						<select class="form-control" id="pagination">
							<?php $n = request('n', 10); ?>
							@for($i = 10; $i <= 100; $i += 10)
								<option value="{{ $i }}" <?php echo $i == $n ? 'selected' : ''; ?>>
									{{ $i }}
								</option>
							@endfor
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
										@if($user->groups->count() == 1)
											{{ $user->groups->first()->name }}
										@elseif($user->groups->count() == 2)
											{{ $user->groups->get(0)->name }}, {{ $user->groups->get(1)->name }}
										@elseif($user->groups->count() > 2)
										{{ $user->groups->get(0)->name }}, {{ $user->groups->get(1)->name }}, ...
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
			</div>
		</form>
		<nav>
		{{ $users->appends(['n' => request('n', 10), 'q' => request('q')])->links('pagination::bootstrap-4') }}
	</nav>
	</div>

@endsection