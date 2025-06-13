@extends('layouts.app')

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            <h5>Nieuwe gebruiker</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group row">
                    <label for="type" class="col-sm-3 col-form-label">Type *</label>
                    <div class="col-sm-6">
                        <select class="form-control form-control-chosen" id="type" name="type">
                            <option value="student" <?php echo old('type') == 'student' ? 'selected' : ''; ?>>
                                Student
                            </option>
                            <option value="teacher" <?php echo old('type') == 'teacher' ? 'selected' : ''; ?>>
                                Docent
                            </option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">D-nummer / afkorting *	</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input" id="id" name="id" placeholder="D123456 / ab01" value="{{ old('id') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Naam *</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control input" id="name" name="name" value="{{ old('name') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="email" class="col-sm-3 col-form-label">E-mail</label>
                    <div class="col-sm-6">
                        <input type="email" class="form-control input" id="email" name="email" placeholder="(leeg laten om automatisch in te vullen)" value="{{ old('email') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="groups" class="col-sm-3 col-form-label">Groepen</label>
                    <div class="col-sm-6">
                        <select multiple class="form-control form-control-chosen" id="groups" name="groups[]" data-placeholder="Kies groep(en)">
                            @foreach($groups as $name => $list)
                                <optgroup label="{{ ucfirst($name) }}">
                                    @foreach($list as $group)
                                        <option value="{{ $group->id }}">
                                            {{ $group->name }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">Wachtwoord *</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input" id="password" name="password">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password_confirmation" class="col-sm-3 col-form-label">Wachtwoord bevestigen *</label>
                    <div class="col-sm-6">
                        <input type="password" class="form-control input" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

            <button type="submit" class="button button-success"><i class="fa fa-save"></i> Opslaan</button>
            </form>
        </div>
    </div>

@endsection
