@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')
	
	<div class="container spaced-container">

		@if (session('success'))
		<div class="alert alert-success">
			Link <strong><a href="http://amo.rocks/{{ session('success') }}" target="_blank">amo.rocks/{{ session('success') }}</a></strong> gemaakt!
		</div>
		@endif
		
		<form action="/links" method="POST">
			{{ method_field('DELETE') }}
			{{ csrf_field() }}
			<div class="row">
				<div class="col-lg-12">
					<div class="btn-group">
						<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijderen</button>
						<a class="btn btn-success" href="/links/create"><i class="fa fa-plus"></i> Nieuw</a>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12">
					<table id="check-table" class="table my-table table-striped table-hover">
						<thead>
							<tr>
								<th class="th5p">&nbsp;</th>
								<th class="th20p">Kort</th>
								<th class="th35p">Lang</th>
								<th class="th25p">Gemaakt</th>
								<th class="th15p">Acties</th>
							</tr>
						</thead>
						<tbody>
							@foreach($links as $link)
								<tr>
									<td><input type="checkbox" name="delete[]" value="{{ $link->id }}"></td>
									<td>{{ $link->short }}</td>
									<td>{{ $link->url }}</td>
									<td>{{ $link->creator()->name }}, {{ $link->created_at }}</td>
									<td>
										<div class="btn-group">
											<a class="btn btn-danger" href="/links/{{ $link->short }}/delete"><i class="fa fa-trash"></i></a>
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