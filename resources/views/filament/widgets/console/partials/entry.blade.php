@props([
    'tone' => 'gray',
    'strong' => false,
    'label' => '',
    'actor' => null,
    'actorDim' => false,
    'main' => null,
    'mainMono' => false,
    'time' => null,
    'meta' => [],
    'expandable' => false,
])

@php
    $hasActor = filled($actor);
    $hasMain = filled((string) $main);
    $hasMeta = count(array_filter($meta)) > 0;
    $isLong = $expandable && strlen((string) $main) > 90;
@endphp

<div
    class="console-entry {{ $strong ? 'console-entry--strong' : '' }}"
    data-tone="{{ $tone }}"
    @if ($isLong) x-data="{ open: false }" @endif
>
    <div class="console-entry__rail">
        <span class="console-entry__dot" aria-hidden="true"></span>
        <span class="console-entry__label">{{ $label }}</span>
    </div>

    <div class="console-entry__content">
        @if ($hasActor || $hasMain)
            <div
                class="console-entry__main {{ $mainMono ? 'console-entry__main--mono' : '' }} {{ $isLong ? 'console-entry__main--clamp' : '' }}"
                @if ($isLong) :class="open && 'console-entry__main--open'" @endif
            >
                @if ($hasActor)
                    <span class="console-entry__actor {{ $actorDim ? 'console-entry__actor--dim' : '' }}">{{ $actor }}</span>
                    @if ($hasMain)<span class="console-entry__sep" aria-hidden="true">·</span>@endif
                @endif

                @if ($hasMain)
                    {{ $main }}
                @endif
            </div>
        @endif

        @if ($hasMeta)
            <div class="console-entry__meta">{{ implode('  ·  ', array_filter($meta)) }}</div>
        @endif
    </div>

    @if ($isLong)
        <div class="console-entry__expand">
            <button
                type="button"
                class="console-entry__expand-btn"
                :aria-expanded="open.toString()"
                x-on:click="open = ! open"
            >
                <svg class="console-entry__chevron" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 8l5 5 5-5"></path>
                </svg>
                <span x-text="open ? 'less' : 'more'"></span>
            </button>
        </div>
    @endif

    <div class="console-entry__time">{{ $time }}</div>
</div>
