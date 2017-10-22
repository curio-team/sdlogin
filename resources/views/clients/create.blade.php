@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<h5>Nieuwe app</h5>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/clients" method="POST">
			{{ csrf_field() }}

			<div class="form-group row">
		    	<label for="name" class="col-sm-3 col-form-label">App naam *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="name" name="name">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="redirect" class="col-sm-3 col-form-label">Redirect URL *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="redirect" name="redirect">
		        	<small class="form-text text-muted">If you use Amoclient, this should be: http://yoursite/amoclient/callback</small>
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection