@php
    use App\Models\ActivityLog;

    $tone = fn (string $action): string => match ($action) {
        'deleted' => 'danger',
        'failed_login' => 'warning',
        'login', 'registered', 'invoice_generated' => 'success',
        default => 'gray',
    };
@endphp

<div class="console-feed">
    @foreach ($records as $record)
        @include('filament.widgets.console.partials.entry', [
            'tone' => $tone($record->action),
            'strong' => false,
            'label' => strtoupper(ActivityLog::ACTIONS[$record->action] ?? $record->action),
            'actor' => $record->user?->name ?: 'Guest / system',
            'actorDim' => $record->user === null,
            'main' => $record->description,
            'mainMono' => true,
            'time' => $record->created_at?->format('M d, H:i'),
            'meta' => array_values(array_filter([
                $record->farm?->name,
                $record->ip_address,
            ])),
            'expandable' => false,
        ])
    @endforeach
</div>
