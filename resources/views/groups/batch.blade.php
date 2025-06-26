@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <h5>Nieuwe klassen</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/groups/batch" method="POST">
                @csrf

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Type *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control-plaintext input" readonly value="Klas">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_start" class="col-sm-3 col-form-label">Startdatum *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input" id="date_start" name="date_start" value="{{ old('date_start', date('Y') . '-08-01') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="date_end" class="col-sm-3 col-form-label">Einddatum *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input" id="date_end" name="date_end" value="{{ old('date_end', date('Y')+1 . '-07-31') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="names" class="col-sm-3 col-form-label">Namen *</label>
                    <div class="col-sm-6">
                        <textarea name="names" id="mames" cols="30" rows="15" class="form-control input">
@php $letters = array('a', 'b', 'c', 'd', 'n'); @endphp
@foreach ($letters as $letter)
TTSDB-sd4o{{ date('y') . $letter }}
@endforeach</textarea>
                    </div>
                </div>

            <button type="submit" class="button button-success"><i class="fa fa-save"></i> Opslaan</button>
            </form>
        </div>
    </div>

@endsection
