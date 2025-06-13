@extends('layouts.app')

@section('content')

	<div class="container spaced-container glassy full-edge">
        <div>
            <h3>Weet je het zeker?</h3>

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
            </table>

            <form action="{{ route('clients.destroy', $client) }}" method="POST">
                @method('DELETE')
                @csrf

                <button type="submit" class="button button-danger">
                    <i class="fa fa-trash"></i> Ga door met verwijderen
                </button>
            </form>

        </div>
    </div>

@endsection
