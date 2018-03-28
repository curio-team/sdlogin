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
		
		<h5>Nieuwe link</h5>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/links" method="POST">
			{{ csrf_field() }}
			
			<div class="form-group row">
		    	<label for="type" class="col-sm-3 col-form-label">Lang *:</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}">
		      	</div>
		    </div>
			<div class="form-group row">
		    	<label for="name" class="col-sm-3 col-form-label">Kort:</label>
		     	<div class="col-sm-6">
		     		<div class="input-group">
			     		<div class="input-group-addon">
				        	<div class="input-group-text">http://amo.rocks/</div>
				        </div>
			        	<input type="text" class="form-control" id="short" name="short" value="{{ old('short') }}">
			        </div>
			        <small class="form-text text-muted">Laat leeg voor willekeurige link.</small>
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="on_frontpage" class="col-sm-3 col-form-label">Toon op dashboard:</label>
		     	<div class="col-sm-6">
		     		<select name="on_frontpage" id="on_frontpage">
		     			<option value="0" selected>Nee</option>
		     			<option value="1">Ja</option>
		     		</select>
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection