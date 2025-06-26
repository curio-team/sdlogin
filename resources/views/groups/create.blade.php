@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <h5>Nieuwe groep</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/groups" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Naam *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input" id="name" name="name" value="{{ old('name') }}" placeholder="RIO4-AMO1A">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type" class="col-sm-3 col-form-label">Type *</label>
                    <div class="col-sm-6">
                        <select class="form-control form-control-chosen" name="type" id="type">
                            <option value="class">Klas</option>
                            <option value="group">Overig</option>
                        </select>
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

                <button type="submit" class="button button-success"><i class="fa fa-save"></i> Opslaan</button>
            </form>
        </div>
    </div>

@endsection
