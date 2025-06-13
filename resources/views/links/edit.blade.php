@extends('layouts.app')

@section('content')

	<div class="container spaced-container glassy full-edge">
        <div>
            <h5>Link aanpassen</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('links.update', $link->short) }}" method="POST">
                @method('PATCH')
                @csrf

                <div class="form-group row">
                    <div class="col-sm-12">
                        <p style="font-size: 1.1rem;">curio.codes/{{ $link->short }} <strong><i class="fa fa-long-arrow-right"></i></strong> {{ $link->url }}</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="password" class="col-sm-3 col-form-label">URL (lang):</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" id="url" name="url" value="{{ $link->url ?? old('url') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="on_frontpage" class="col-sm-3 col-form-label">Toon op dashboard:</label>
                    <div class="col-sm-6 d-flex align-items-center">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <input type="checkbox" name="on_frontpage" id="on_frontpage" value="1" @if($link->on_frontpage) checked @endif>
                            </div>
                            <div class="input-group-addon">
                                <div class="input-group-text">met als titel:</div>
                            </div>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $link->title ?? old('title') }}">
                        </div>
                    </div>
                </div>

            <button type="submit" class="button button-success"><i class="fa fa-save"></i> Opslaan</button>
            </form>
        </div>
    </div>

@endsection
