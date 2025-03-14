@extends('layouts.app')

@section('content')
    <div class="container spaced-container">

        <h5>Klassenlijst uit Osiris importeren</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('notice'))
        <div class="alert alert-success">
            {{ session('notice') }}
        </div>
        @endif

        <p><strong>Let op:</strong></p>
        <ul>
            <li>TODO: Instructie hoe export in osiris te maken</li>
            <li>Zet eerst de klassen klaar voor dit schooljaar (naam volgens TTSDB-SD4O{{ date('y') }}A).</li>
            <li>Gebruikers worden toegevoegd aan een klas als er nu een actieve klas met die naam is (klassen worden niet automatisch aangemaakt). Toevoegen aan klassen die in de toekomst actief worden kan met de <em>Fake date</em>, bijvoorbeeld alvast voor het volgende schooljaar.</li>
            <li>Als een gebruiker al bestaat wordt die aan de genoemde klas toegevoegd. Historische klassen worden niet verwijderd, actieve klassen wel.</li>
        </ul>

        <form action="{{ route('users.import_osiris_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group row">
                <label for="import" class="col-sm-3 col-form-label">Osiris Export JSON *</label>
                <div class="col-sm-6">
                    <textarea class="form-control" name="import" id="import" rows="10" placeholder="Plak hier de JSON van de Osiris export"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="fake_date" class="col-sm-3 col-form-label">Fake date</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="fake_date" id="fake_date" placeholder="{{ date('d-m-Y') }}">
                    <small class="form-text text-muted">Voeg gebruikers toe aan groepen die op bovenstaande datum actief zijn</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="csv" class="col-sm-3 col-form-label">Zoek gebruikers volgens</label>
                <div class="col-sm-6 d-flex align-items-center">
                    <input type="radio" name="find_user_prefix" value="i" id="find_user_i" checked>
                    <label class="m-0 pl-2 pr-3" for="find_user_i">i123456</label>
                    <input type="radio" name="find_user_prefix" value="D" id="find_user_D">
                    <label class="m-0 pl-2 text-muted" for="find_user_D">D123456 (legacy)</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Uploaden</button>
        </form>
    </div>

@endsection
