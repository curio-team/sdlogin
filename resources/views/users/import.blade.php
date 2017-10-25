@extends('layouts.app')

@section('content')
    <div class="container spaced-container">

        <h5>Gebruikers importeren</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <p><strong>Let op:</strong></p>
        <ul>
            <li>Zet eerst de klassen klaar voor dit schooljaar (naam volgens RIO4-AMO1A).</li>
            <li>Klassen worden niet automatisch aangemaakt.</li>
            <li>Als een gebruiker al bestaat, wordt enkel zijn nieuwe klas toegevoegd.</li>
            <li>Als een gebruiker halverwege het jaar van klas wisselt (oude verwijderen), moet je dat handmatig doen</li>
            <li>Upload een radius_edictis.csv van de I-schijf.</li>
            <li><em>Let op:</em> verander eerst de encoding naar UTF-8!</li>
        </ul>

        <form action="/users/import" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class="form-group row">
                <label for="csv" class="col-sm-3 col-form-label">Upload CSV *</label>
                <div class="col-sm-6">
                    <input type="file" class="form-control-file" name="csv" id="csv">
                </div>
            </div>
            <button type="submit" class="btn btn-success"><i class="fa fa-upload"></i> Uploaden</button>
        </form>
    </div>

@endsection