@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            @if (session('notice'))
            <div class="alert alert-success">
                {{ session('notice') }}
            </div>
            @endif

            <div class="row">
                <div class="col-lg-12">
                    <table id="check-table" class="table my-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="th30p">Naam</th>
                                <th class="th20p">Startdatum</th>
                                <th class="th20p">Einddatum</th>
                                <th class="th30p">Groepslogin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr <?php echo $group->date_end < \Carbon\Carbon::now() ? 'class="historical"' : '';?>>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->date_start }}</td>
                                    <td>{{ $group->date_end }}</td>
                                    <td>
                                        <div class="button-group">
                                            <a class="button button-warning" href="/grouplogin/{{ $group->id }}"><i class="fa fa-fw fa-key"></i> Groepslogin opvragen</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
