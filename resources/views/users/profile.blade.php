@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <h5>Mijn profiel</h5>

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
                <ul>
                    @foreach (session('notice') as $msg)
                    <li>{{ $msg }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('users.profile_update', $user->id) }}" method="POST">
                @method('PATCH')
                @csrf

                <div class="form-group row">
                    <div class="col-sm-3">Type</div>
                    <div class="col-sm-6"><?php echo $user->type == 'teacher' ? 'Docent' : 'Student'; ?></div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">D-nummer / afkorting</div>
                    <div class="col-sm-6">{{ $user->id }}</div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">Naam</div>
                    <div class="col-sm-6">{{ $user->name }}</div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-3">E-mail</div>
                    <div class="col-sm-6">{{ $user->email }}</div>
                </div>

                <fieldset>
                    <legend>Wachtwoord aanpassen</legend>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label">Huidige wachtwoord</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control input" id="password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_new" class="col-sm-3 col-form-label">Nieuw wachtwoord</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control input" id="password_new" name="password_new">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password_new_confirmation" class="col-sm-3 col-form-label">Wachtwoord bevestigen</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control input" id="password_new_confirmation" name="password_new_confirmation">
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Groepen</legend>
                    <div class="form-group row">
                        <div class="col-sm-3">Overicht van groepen</div>
                        <div class="col-sm-6">
                            <table>
                                @foreach($user_groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>({{ $group->date_start }} t/m {{ $group->date_end }})</td>
                                </tr>
                                @endforeach
                                @foreach($user_groups_history as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>({{ $group->date_start }} t/m {{ $group->date_end }})</td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </fieldset>

                <button type="submit" class="button button-success"><i class="fa fa-save"></i> Opslaan</button>
            </form>
        </div>
    </div>

@endsection
