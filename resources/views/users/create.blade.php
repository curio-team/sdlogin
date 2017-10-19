@extends('layouts.app')

@push('styles')
	<link rel="stylesheet" href="/chosen/chosen.min.css">
	<link rel="stylesheet" href="/chosen/bootstrap-chosen.css">
@endpush

@push('scripts')
	<script type="text/javascript" src="/chosen/chosen.jquery.min.js"></script>
	<script type="text/javascript">
		jQuery("#type").chosen();
		jQuery("#groups").chosen();
	</script>
@endpush

@section('content')
	
	<div class="container spaced-container">
		
		<h5>Nieuwe gebruiker</h5>

		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif

		<form action="/users/" method="POST">
			{{ csrf_field() }}

			<div class="form-group row">
		    	<label for="type" class="col-sm-3 col-form-label">Type *</label>
		     	<div class="col-sm-6">
		        	<select class="form-control" id="type" name="type">
		        		<option value="student">Student</option>
		        		<option value="teacher">Docent</option>
		        	</select>
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="id" class="col-sm-3 col-form-label">D-nummer / afkorting *	</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="id" name="id" placeholder="D123456 / ab01">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="name" class="col-sm-3 col-form-label">Naam *</label>
		     	<div class="col-sm-6">
		        	<input type="text" class="form-control" id="name" name="name">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="email" class="col-sm-3 col-form-label">E-mail</label>
		     	<div class="col-sm-6">
		        	<input type="email" class="form-control" id="email" name="email" placeholder="(leeg laten om automatisch in te vullen)">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="groups" class="col-sm-3 col-form-label">Groepen</label>
		     	<div class="col-sm-6">
		        	<select multiple class="form-control form-control-chosen" id="groups" name="groups[]" data-placeholder="Kies groep(en)">
		        		@foreach($groups as $name => $list)
			        		<optgroup label="{{ ucfirst($name) }}">
			        			@foreach($list as $group)
				        			<option value="{{ $group->id }}">
				        				{{ $group->name }}
				        			</option>
				        		@endforeach
			        		</optgroup>
		        		@endforeach
		        	</select>
		      	</div>
		    </div>
			<div class="form-group row">
		    	<label for="password" class="col-sm-3 col-form-label">Wachtwoord *</label>
		     	<div class="col-sm-6">
		        	<input type="password" class="form-control" id="password" name="password">
		      	</div>
		    </div>
		    <div class="form-group row">
		    	<label for="password_confirmation" class="col-sm-3 col-form-label">Wachtwoord bevestigen *</label>
		     	<div class="col-sm-6">
		        	<input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
		      	</div>
		    </div>

		   <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Opslaan</button>
		</form>
	</div>

@endsection