@extends('layouts.app')

@section('content')
    <div class="container mt-5 glassy full-edge">
        <div>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <h4>Auditlog</h4>
                </div>
            </div>

            <form method="GET" action="{{ route('audits.index') }}" id="filter-form">
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="form-inline">
                            <div class="input-group mr-2 mb-2">
                                <select name="event" class="form-control form-control-chosen"
                                    onchange="this.form.submit()">
                                    <option value="">Alle events</option>
                                    @foreach ($events as $event)
                                        <option value="{{ $event }}"
                                            {{ request('event') === $event ? 'selected' : '' }}>
                                            {{ ucfirst($event) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group mr-2 mb-2">
                                <select name="model" class="form-control form-control-chosen"
                                    onchange="this.form.submit()">
                                    <option value="">Alle modellen</option>
                                    @foreach ($modelTypes as $model)
                                        <option value="{{ $model }}"
                                            {{ request('model') === $model ? 'selected' : '' }}>
                                            {{ class_basename($model) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="input-group mr-2 mb-2">
                                <input type="text" name="user_id" class="form-control input" placeholder="Gebruiker ID"
                                    value="{{ request('user_id') }}">
                                <span class="input-group-button">
                                    <button type="submit" class="button button-secondary">Zoeken</button>
                                </span>
                            </div>

                            @if (request('event') || request('model') || request('user_id'))
                                <a href="{{ route('audits.index') }}" class="button button-secondary mb-2">
                                    <i class="fa fa-times"></i> Wis filters
                                </a>
                            @endif

                            <div class="input-group ml-auto mb-2">
                                <select class="form-control form-control-chosen" id="pagination" name="n" onchange="this.form.submit()">
                                    @php $n = request('n', 25); @endphp
                                    @foreach ([25, 50, 100] as $size)
                                        <option value="{{ $size }}" {{ $size == $n ? 'selected' : '' }}>
                                            {{ $size }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table my-table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="th15p">Tijdstip</th>
                                <th class="th10p">Event</th>
                                <th class="th15p">Model</th>
                                <th class="th15p">Record</th>
                                <th class="th20p">Gebruiker</th>
                                <th class="th15p">IP-adres</th>
                                <th class="th10p">Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($audits as $audit)
                                <tr>
                                    <td>
                                        <small>{{ $audit->created_at->format('d-m-Y H:i:s') }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $badge = match ($audit->event) {
                                                'created' => 'success',
                                                'updated' => 'primary',
                                                'deleted' => 'danger',
                                                'restored' => 'warning',
                                                default => 'secondary',
                                            };
                                        @endphp
                                        <span class="badge badge-{{ $badge }}">{{ $audit->event }}</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ class_basename($audit->auditable_type) }}</small>
                                    </td>
                                    <td>
                                        <code>{{ $audit->auditable_id }}</code>
                                    </td>
                                    <td>
                                        @if ($audit->user)
                                            <a href="/users/{{ $audit->user_id }}/edit">
                                                {{ $audit->user->name }}
                                            </a>
                                            <small class="text-muted d-block">
                                                {{ $audit->user->type }} &bull; {{ $audit->user_id }}
                                            </small>
                                        @elseif ($audit->user_id)
                                            <span class="text-muted">{{ $audit->user_id }} (verwijderd)</span>
                                        @else
                                            <span class="text-muted">Systeem</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $audit->ip_address ?? '—' }}</small>
                                    </td>
                                    <td>
                                        <a class="button button-primary icon-only"
                                            href="{{ route('audits.show', $audit->id) }}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Geen auditrecords gevonden.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{ $audits->appends(request()->only(['event', 'model', 'user_id', 'n']))->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
