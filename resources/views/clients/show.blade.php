@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <a class="button" href="/clients"><i class="fa fa-chevron-left"></i> Terug</a>

            <form action="{{ route('clients.change-name', $client) }}" method="post" class="mt-4">
                @csrf
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Naam:</label>
                    <div class="col-sm-6">
                        <h5><input type="text" value="{{ $client->name }}" class="form-control input" name="name" id="name"></h5>
                    </div>
                    <div class="col-sm-4">
                        <button type="submit" class="button button-secondary"><i class="fa fa-save"></i>Wijzig naam</button>
                    </div>
                </div>
            </form>

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
                <tr>
                    <th>Dev/test-app:</th>
                    <td>&nbsp;</td>
                    <td><?php echo $client->for_development ? 'Ja' : 'Nee'; ?> <a href="{{ route('clients.toggle-dev', $client) }}">(toggle)</a></td>
                </tr>
            </table>
        </div>
    </div>

@endsection
