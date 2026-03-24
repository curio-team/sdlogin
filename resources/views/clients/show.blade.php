@extends('layouts.app')

@section('content')

<div class="container mt-5 glassy full-edge">
    <div>
        <a class="button"
           href="/clients"><i class="fa fa-chevron-left"></i> Terug</a>

        <form action="{{ route('clients.change-name', $client) }}"
              method="post"
              class="mt-4">
            @csrf
            <div class="form-group row">
                <label for="name"
                       class="col-sm-2 col-form-label">Naam:</label>
                <div class="col-sm-6">
                    <h5><input type="text"
                               value="{{ $client->name }}"
                               class="form-control input"
                               name="name"
                               id="name"></h5>
                </div>
                <div class="col-sm-4">
                    <button type="submit"
                            class="button button-secondary"><i class="fa fa-save"></i>Wijzig naam</button>
                </div>
            </div>
        </form>

        <table>
            <tr>
                <th>Redirect URL(s):</th>
                <td>&nbsp;</td>
                <td>{{ implode(', ', $client->redirect_uris) }}</td>
            </tr>
            <tr>
                <th>Client ID:</th>
                <td>&nbsp;</td>
                <td>{{ $client->id }}</td>
            </tr>
            <tr>
                <th>Client secret:</th>
                <td>&nbsp;</td>
                <td>
                    @if (session('plain_secret'))
                    <strong>{{ session('plain_secret') }}</strong>
                    <small class="text-muted d-block">Kopieer dit nu — het wordt niet opnieuw getoond.</small>
                    @else
                    <em class="text-muted">Verborgen (alleen zichtbaar direct na aanmaken)</em>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dev/test-app:</th>
                <td>&nbsp;</td>
                <td>
                    <?php echo $client->for_development ? 'Ja' : 'Nee'; ?> <a
                       href="{{ route('clients.toggle-dev', $client) }}">(toggle)</a>
                </td>
            </tr>
        </table>
    </div>
</div>

@endsection