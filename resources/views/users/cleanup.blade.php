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

		<form action="/users/cleanup" method="POST">
			@csrf
			<div class="row">
				<div class="col-lg-12 d-flex align-items-center">
					<div class="btn-group">
						<a class="btn btn-secondary" href="/users"><i class="fa fa-chevron-left"></i> Terug</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<p class="mt-4 mb-0"><strong>Gebruikers zonder actieve groep:</strong></p>
					<p class="mt-0 mb-4">Aan het begin van een schooljaar moeten alle klassenlijsten geimporteerd worden, nadat de juiste groepen zijn gemaakt. Daarna blijven de afgestudeerde en gestopte studenten over <em>zonder</em> actieve groep. Controleer de lijst en vink eventueel studenten uit die behouden moeten blijven. In deze lijst komen per definitie geen docent-accounts voor.</p>
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
								<th class="th30p">Aangemaakt</th>
							</tr>
						</thead>
						<tbody>
							@foreach($users as $user)
								<tr>
									<td><input type="checkbox" name="delete[]" value="{{ $user->id }}" checked></td>
									<td>{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->created_at }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			<button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Verwijder geselecteerde rijen</button>
		</form>
	</div>

@endsection
