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

            <form action="{{ route('users.cleanup_do') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12 d-flex align-items-center">
                        <div class="button-group">
                            <a class="button button-secondary" href="{{ route('users.index') }}"><i class="fa fa-chevron-left"></i> Terug</a>
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
                                    <th class="th5p">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" class="checkbox" checked onchange="toggleAll(this, 'check-table')">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th class="th15p">ID</th>
                                    <th class="th35p">Naam</th>
                                    <th class="th30p">Aangemaakt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Geen gebruikers zonder actieve groep gevonden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="button button-danger"><i class="fa fa-trash"></i> Verwijder geselecteerde rijen</button>
            </form>
        </div>
    </div>

    <div class="container mt-5 glassy full-edge">
        <div>
            <form method="GET" action="{{ route('users.cleanup') }}" class="mb-3 d-flex align-items-center gap-2">
                <label for="years_old" class="mb-0">Jaren terug:</label>
                <input type="number" id="years_old" name="years_old" value="{{ $yearsOld }}" min="1" class="form-control w-auto">
                <button type="submit" class="button button-secondary">Toepassen</button>
            </form>
            <form action="{{ route('users.cleanup_do') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <p class="mt-4 mb-0"><strong>Gebruikers aangemaakt meer dan {{ $yearsOld }} jaar geleden:</strong></p>
                        <p class="mt-0 mb-4">Onderstaande studenten zijn meer dan {{ $yearsOld }} jaar geleden aangemaakt en zijn waarschijnlijk al afgestudeerd. Controleer de lijst en vink eventueel studenten uit die behouden moeten blijven.</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="check-table-old" class="table my-table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="th5p">
                                        <label class="checkbox-wrapper">
                                            <input type="checkbox" class="checkbox" checked onchange="toggleAll(this, 'check-table-old')">
                                            <span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th class="th15p">ID</th>
                                    <th class="th35p">Naam</th>
                                    <th class="th30p">Aangemaakt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($oldUsers as $user)
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
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Geen oude gebruikers gevonden.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <button type="submit" class="button button-danger"><i class="fa fa-trash"></i> Verwijder geselecteerde rijen</button>
            </form>
        </div>
    </div>

    <script>
        function toggleAll(checkbox, tableId) {
            const table = document.getElementById(tableId);
            const checkboxes = table.querySelectorAll('tbody input[type="checkbox"]');
            const isChecked = checkbox.checked;

            checkboxes.forEach(cb => {
                cb.checked = isChecked;
            });
        }
    </script>
@endsection
