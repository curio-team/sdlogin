@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<h5>Nieuwe klassen</h5>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/groups/batch" method="POST">
			{{ csrf_field() }}

		    <div class="form-group row">
		    	<label class="col-sm-3 col-form-label">Type *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control-plaintext" readonly value="Klas">
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

		    <div class="form-group row">
		    	<label for="names" class="col-sm-3 col-form-label">Namen *</label>
		     	<div class="col-sm-6">
		     		<textarea name="names" id="mames" cols="30" rows="15" class="form-control">
RIO4-AMO1A
RIO4-AMO1B
RIO4-AMO1C
RIO4-AMO1D
RIO4-AMO1E
RIO4-AMO1F
RIO4-AMO2A
RIO4-AMO2B
RIO4-AMO2C
RIO4-AMO2D
RIO4-AMO3A
RIO4-AMO3B
RIO4-AMO3C</textarea>
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection