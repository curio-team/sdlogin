@extends('layouts.app')

@section('content')
    <div class="container mt-5 glassy full-edge">
        <div>
            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="button-group mb-3">
                        <a class="button button-secondary" href="{{ route('audits.index') }}">
                            <i class="fa fa-arrow-left"></i> Terug
                        </a>
                    </div>
                    <h4>Auditdetail</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <table class="table my-table">
                        <tbody>
                            <tr>
                                <th style="width:35%">Event</th>
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
                            </tr>
                            <tr>
                                <th>Tijdstip</th>
                                <td>{{ $audit->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                            <tr>
                                <th>Model</th>
                                <td>
                                    {{ class_basename($audit->auditable_type) }}
                                    <small class="text-muted d-block">{{ $audit->auditable_type }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Record ID</th>
                                <td><code>{{ $audit->auditable_id }}</code></td>
                            </tr>
                            <tr>
                                <th>Gebruiker</th>
                                <td>
                                    @if ($audit->user)
                                        <a href="/users/{{ $audit->user_id }}/edit">{{ $audit->user->name }}</a>
                                        <small class="text-muted d-block">
                                            {{ $audit->user->type }} &bull; {{ $audit->user_id }}
                                        </small>
                                    @elseif ($audit->user_id)
                                        {{ $audit->user_id }} <small class="text-muted">(verwijderd)</small>
                                    @else
                                        <span class="text-muted">Systeem</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>IP-adres</th>
                                <td>{{ $audit->ip_address ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>User Agent</th>
                                <td><small>{{ $audit->user_agent ?? '—' }}</small></td>
                            </tr>
                            <tr>
                                <th>URL</th>
                                <td><small>{{ $audit->url ?? '—' }}</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            @if (!empty($audit->old_values) || !empty($audit->new_values))
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <h5>Oude waarden</h5>
                        @if (!empty($audit->old_values))
                            <table class="table my-table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Veld</th>
                                        <th>Waarde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audit->old_values as $field => $value)
                                        <tr>
                                            <td><code>{{ $field }}</code></td>
                                            <td>
                                                @if (is_null($value))
                                                    <span class="text-muted">null</span>
                                                @elseif (is_bool($value))
                                                    {{ $value ? 'true' : 'false' }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">—</p>
                        @endif
                    </div>

                    <div class="col-lg-6">
                        <h5>Nieuwe waarden</h5>
                        @if (!empty($audit->new_values))
                            <table class="table my-table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Veld</th>
                                        <th>Waarde</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($audit->new_values as $field => $value)
                                        @php $changed = isset($audit->old_values[$field]) && $audit->old_values[$field] !== $value; @endphp
                                        <tr class="{{ $changed ? 'table-warning' : '' }}">
                                            <td><code>{{ $field }}</code></td>
                                            <td>
                                                @if (is_null($value))
                                                    <span class="text-muted">null</span>
                                                @elseif (is_bool($value))
                                                    {{ $value ? 'true' : 'false' }}
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-muted">—</p>
                        @endif
                    </div>
                </div>
            @else
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <p class="text-muted">Geen waardewijzigingen opgeslagen voor dit event.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
