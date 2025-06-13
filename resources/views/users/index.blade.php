@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
	<script type="text/javascript" src="/js/pagination.js"></script>
@endpush

@section('content')

	<div class="container spaced-container glassy full-edge">
        <div>
            @if (session('notice'))
            <div class="alert alert-success">
                {{ session('notice') }}
            </div>
            @endif

            <form action="{{ route('users.destroy') }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div class="button-group">
                            <button type="submit" class="button button-danger"><i class="fa fa-trash"></i> Verwijderen</button>
                            <a class="button button-success" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Nieuw</a>
                            <a class="button button-primary" href="{{ route('users.import_eol') }}"><i class="fa fa-upload"></i> Import EOL</a>
                            <a class="button button-warning" href="{{ route('users.cleanup') }}"><i class="fa fa-eraser"></i> Opruimen</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="mt-4 form-inline justify-content-end">
                            <div class="input-group mr-2">
                                @if(request('q'))
                                    <span class="input-group-btn">
                                        <button type="button" id="search_clear" class="button button-secondary">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </span>
                                @endif
                                <input type="text" id="search_text" placeholder="Id, naam, groep" class="form-control" value="{{ request('q') }}">
                                <span class="input-group-btn">
                                    <button type="button" id="search_button" class="button button-secondary">Zoeken</button>
                                </span>
                            </div>

                            <select class="form-control" id="pagination">
                                <?php $n = request('n', 10); ?>
                                @for($i = 10; $i <= 100; $i += 10)
                                    <option value="{{ $i }}" <?php echo $i == $n ? 'selected' : ''; ?>>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <table id="check-table" class="table my-table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="th5p">&nbsp;</th>
                                    <th class="th15p">ID</th>
                                    <th class="th35p">Naam</th>
                                    <th class="th30p">Groepen (huidig)</th>
                                    <th class="th15p">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td><input type="checkbox" name="delete[]" value="{{ $user->id }}"></td>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>
                                            @if($user->groups->count() >= 1)
                                                {{ $user->groups->first()->name }}
                                                @if($user->groups->count() > 1)
                                                    , ...
                                                @endif
                                            @else
                                                (geen)
                                            @endif
                                        </td>
                                        <td>
                                            <div class="button-group">
                                                <a class="button button-primary" href="/users/{{ $user->id }}/edit"><i class="fa fa-pencil"></i></a>
                                                <a class="button button-danger" href="{{ route('users.delete', $user->id) }}"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
            {{ $users->appends(['n' => request('n'), 'q' => request('q')])->links('pagination::bootstrap-4') }}
        </div>
    </div>

@endsection
