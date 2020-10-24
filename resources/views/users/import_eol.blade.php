@extends('layouts.app')

@section('content')
    <div class="container spaced-container">

        <h5>Klassenlijst uit EOL importeren</h5>

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
            <li>Download een klassenlijst uit EOL onder Informatie &gt; Klassenlijst, klik op het icoon onder <em>XLS</em>.</li>
            <li>Zet eerst de klassen klaar voor dit schooljaar (naam volgens RIO4-AMO1A).</li>
            <li>Gebruikers worden toegevoegd aan een klas als er nu een actieve klas met die naam is (klassen worden niet automatisch aangemaakt). Toevoegen aan klassen die in de toekomst actief worden kan met de <em>Fake date</em>, bijvoorbeeld alvast voor het volgende schooljaar.</li>
            <li>Als een gebruiker al bestaat wordt hij aan de genoemde klas toegevoegd. Historische klassen worden niet verwijderd, actieve klassen wel.</li>
        </ul>

        <form action="/users/import/eol" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group row">
                <label for="csv" class="col-sm-3 col-form-label">Upload Excel *</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control-file" name="file" id="file">
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
                <label for="csv" class="col-sm-3 col-form-label">Zoek gebruiker op</label>
                <div class="col-sm-6 d-flex align-items-center">
                    <input type="radio" name="find_user" value="i" id="find_user_i" checked>
                    <label class="m-0 pl-2 pr-3" for="find_user_i">i123456</label>
                    <input type="radio" name="find_user" value="D" id="find_user_D">
                    <label class="m-0 pl-2 text-muted" for="find_user_D">D123456 (legacy)</label>
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Uploaden</button>
        </form>
    </div>

@endsection