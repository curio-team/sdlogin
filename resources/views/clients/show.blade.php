@extends('layouts.app')

@section('content')

	<div class="container spaced-container glassy full-edge">
        <div>
            <a class="button" href="/clients"><i class="fa fa-chevron-left"></i> Terug</a>

            <form action="{{ route('clients.change-name', $client) }}" method="post">
                @csrf
                <div class="form-group row">
                    <div class="col-sm-12">
                    <h5><input type="text" value="{{ $client->name }}" class="form-control" name="name"></h5>
                    </div>
                </div>

                <button type="submit" class="button button-secondary"><i class="fa fa-save"></i>Wijzig naam</button>
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
