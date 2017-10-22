@extends('layouts.app')

@section('content')
	
	<div class="container spaced-container">
		
		<a class="btn btn-primary" href="/clients"><i class="fa fa-chevron-left"></i> Terug</a>

		<h5>{{ $client->name }}</h5>
		<table>
			<tr>
				<th>Eigenaar:</th>
				<td>&nbsp;</td>
				<td>{{ $client->user_id }}</td>
			</tr>
			<tr>
				<th>Redirect URL:</th>
				<td>&nbsp;</td>
				<td>{{ $client->redirect }}</td>
			</tr>
			<tr>
				<th>Client ID:</th>
				<td>&nbsp;</td>
				<td>{{ $client->id }}</td>
			</tr>
			<tr>
				<th>Client secret:</th>
				<td>&nbsp;</td>
				<td>{{ $client->secret }}</td>
			</tr>
		</table>
	</div>

@endsection