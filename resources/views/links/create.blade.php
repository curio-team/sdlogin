@extends('layouts.app')

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
			@csrf

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
				        	<div class="input-group-text">http://curio.codes/</div>
				        </div>
			        	<input type="text" class="form-control" id="short" name="short" value="{{ old('short') }}">
			        </div>
			        <small class="form-text text-muted">Laat leeg voor willekeurige link.</small>
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="on_frontpage" class="col-sm-3 col-form-label">Toon op dashboard:</label>
		     	<div class="col-sm-6 d-flex align-items-center">
		     		<div class="input-group">
		     			<div class="input-group-addon">
		     				<input type="checkbox" name="on_frontpage" id="on_frontpage" value="1">
		     			</div>
	     				<div class="input-group-addon">
		     				<div class="input-group-text">met als titel:</div>
		     			</div>
		     			<input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}">
		     		</div>
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection
