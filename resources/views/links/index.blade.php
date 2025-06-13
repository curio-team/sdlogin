@extends('layouts.app')

@push('scripts')
	<script type="text/javascript" src="/js/check.js"></script>
@endpush

@section('content')

	<div class="container mt-5 glassy full-edge">
        <div>
            @if (session('success'))
            <div class="alert alert-success">
                Link <strong><a href="http://curio.codes/{{ session('success') }}" target="_blank">curio.codes/{{ session('success') }}</a></strong> gemaakt!
            </div>
            @endif
            @if (session('updated'))
            <div class="alert alert-success">
                Link <strong><a href="http://curio.codes/{{ session('updated') }}" target="_blank">curio.codes/{{ session('updated') }}</a></strong> aangepast!
            </div>
            @endif

            <form action="{{ route('links.destroy') }}" method="POST">
                @method('DELETE')
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="button-group">
                            <button type="submit" class="button button-danger"><i class="fa fa-trash"></i> Verwijderen</button>
                            <a class="button button-success" href="/links/create"><i class="fa fa-plus"></i> Nieuw</a>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <table id="check-table" class="mt-4 table my-table table-striped table-hover table-nowrap">
                            <thead>
                                <tr>
                                    <th class="th5p">&nbsp;</th>
                                    <th class="th20p">Kort</th>
                                    <th class="th35p">Lang</th>
                                    <th class="th25p">Gemaakt</th>
                                    <th class="th15p">Acties</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($links as $link)
                                    <tr>
                                        <td>
                                            <label class="checkbox-wrapper">
                                                <input type="checkbox" class="checkbox" name="delete[]" value="{{ $link->id }}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td><a target="_blank" href="http://curio.codes/{{ $link->short }}">{{ $link->short }}</a></td>
                                        <td>{{ $link->url }}</td>
                                        <td>{{ optional($link->creator())->name }}, {{ $link->created_at }}</td>
                                        <td>
                                            <div class="button-group">
                                                <a class="button button-primary icon-only" href="/links/{{ $link->short }}/edit"><i class="fa fa-pencil"></i></a>
                                                <a class="button button-danger icon-only" href="{{ route('links.delete', $link->short) }}"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
	    </div>
	</div>

@endsection
