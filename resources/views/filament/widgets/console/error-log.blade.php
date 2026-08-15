@php
    $tone = fn (string $level): string => match (strtolower($level)) {
        'critical', 'error' => 'danger',
        'warning' => 'warning',
        'success' => 'success',
        'info', 'debug' => 'gray',
        default => 'gray',
    };
@endphp

<div class="console-feed">
    @foreach ($records as $record)
        @include('filament.widgets.console.partials.entry', [
            'tone' => $tone($record->level),
            'strong' => strtolower((string) $record->level) === 'critical',
            'label' => strtoupper((string) $record->level),
            'actor' => null,
            'actorDim' => false,
            'main' => $record->message,
            'mainMono' => true,
            'time' => $record->created_at?->format('M d, H:i'),
            'meta' => array_values(array_filter([
                $record->type,
                $record->file ? $record->file.($record->line ? ':'.$record->line : '') : null,
                $record->method ?: null,
                $record->url ?: null,
                $record->user?->name,
                $record->farm?->name,
            ])),
            'expandable' => true,
        ])
    @endforeach
</div>
