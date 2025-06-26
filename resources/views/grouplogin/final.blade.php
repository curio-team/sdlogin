@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            @if (session('notice'))
            <div class="alert alert-success">
                {{ session('notice') }}
            </div>
            @endif

            <div class="d-flex justify-content-between">
                <h5><strong>{{ $group->name }}</strong></h5>
                <p class="d-print-none"><i class="fa fa-print"></i> Gebruik <strong>ctrl+p</strong> om deze lijst af te drukken.</p>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <table id="check-table" class="table my-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="th40p">Naam</th>
                                <th class="th30p">Logincode</th>
                                <th class="th30p">Wachtwoord</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userprint as $user)
                                <tr>
                                    <td>{{ $user['name'] }}</td>
                                    <td>{{ $user['id'] }}</td>
                                    <td>{{ $user['pass'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
