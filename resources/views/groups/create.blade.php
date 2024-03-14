@extends('layouts.app')

@push('styles')
	<link rel="stylesheet" href="/chosen/chosen.min.css">
	<link rel="stylesheet" href="/chosen/bootstrap-chosen.css">
@endpush

@push('scripts')
	<script type="text/javascript" src="/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript">
		jQuery("#type").chosen();
	</script>
@endpush

@section('content')

	<div class="container spaced-container">

		<h5>Nieuwe groep</h5>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/groups" method="POST">
			@csrf

			<div class="form-group row">
		    	<label for="name" class="col-sm-3 col-form-label">Naam *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="RIO4-AMO1A">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="type" class="col-sm-3 col-form-label">Type *</label>
		     	<div class="col-sm-6">
		        	<select class="form-control" name="type" id="type">
		        		<option value="class">Klas</option>
		        		<option value="group">Overig</option>
		        	</select>
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="date_start" class="col-sm-3 col-form-label">Startdatum *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="date_start" name="date_start" value="{{ old('date_start', date('Y') . '-08-01') }}">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="date_end" class="col-sm-3 col-form-label">Einddatum *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="date_end" name="date_end" value="{{ old('date_end', date('Y')+1 . '-07-31') }}">
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection
