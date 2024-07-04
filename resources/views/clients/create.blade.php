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
			@csrf

			<div class="form-group row">
		    	<label for="name" class="col-sm-3 col-form-label">App naam *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="redirect" class="col-sm-3 col-form-label">Redirect URL *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="redirect" name="redirect" value="{{ old('redirect') }}">
		        	<small class="form-text text-muted">Als je <a href="https://github.com/curio-team/sdclient">de SD-client</a> gebruikt, is dit iets als: http://yoursite/sdclient/callback</small>
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="for_development" class="col-sm-3 col-form-label">Dev/test-app *</label>
		     	<div class="col-sm-6">
		     		<select name="for_development" id="for_development">
		     			<option value="0">Nee</option>
		     			<option value="1" selected>Ja (verborgen op dashboard)</option>
		     		</select>
		        	<small class="form-text text-muted">Selecteer &quot;Nee&quot; om een knop het dashboard te tonen naar deze app.</small>
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection
