@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            @if (session('notice'))
            <div class="alert alert-success">
                {{ session('notice') }}
            </div>
            @endif

            <form action="/users/cleanup" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="button-group">
                            <a class="button button-secondary" href="/users"><i class="fa fa-chevron-left"></i> Terug</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mt-4 mb-0"><strong>Gebruikers zonder actieve groep:</strong></p>
                        <p class="mt-0 mb-4">Aan het begin van een schooljaar moeten alle klassenlijsten geimporteerd worden, nadat de juiste groepen zijn gemaakt. Daarna blijven de afgestudeerde en gestopte studenten over <em>zonder</em> actieve groep. Controleer de lijst en vink eventueel studenten uit die behouden moeten blijven. In deze lijst komen per definitie geen docent-accounts voor.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="check-table" class="table my-table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="th5p">&nbsp;</th>
                                    <th class="th15p">ID</th>
                                    <th class="th35p">Naam</th>
                                    <th class="th30p">Aangemaakt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" class="checkbox" name="delete[]" value="{{ $user->id }}" checked>
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->created_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="button button-danger"><i class="fa fa-trash"></i> Verwijder geselecteerde rijen</button>
            </form>
        </div>
    </div>

@endsection
