@php
    $tone = fn (string $action): string => match ($action) {
        'failed_login' => 'danger',
        'login' => 'success',
        default => 'gray',
    };

    $label = fn (string $action): string => match ($action) {
        'failed_login' => 'FAILED',
        'login' => 'SIGNED IN',
        default => 'SIGNED OUT',
    };
@endphp

<div class="console-feed">
    @foreach ($records as $record)
        @include('filament.widgets.console.partials.entry', [
            'tone' => $tone($record->action),
            'strong' => $record->action === 'failed_login',
            'label' => $label($record->action),
            'actor' => $record->user?->name ?: 'Guest',
            'actorDim' => $record->user === null,
            'main' => null,
            'mainMono' => false,
            'time' => $record->created_at?->format('M d, H:i'),
            'meta' => array_values(array_filter([
                $record->farm?->name,
                $record->ip_address,
            ])),
            'expandable' => false,
        ])
    @endforeach
</div>
