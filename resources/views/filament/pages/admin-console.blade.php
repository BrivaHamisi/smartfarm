<x-filament-panels::page class="fi-dashboard-page admin-console-page">
    <div class="terminal-masthead">
        <div class="terminal-masthead-dots" aria-hidden="true">
            <span class="terminal-dot terminal-dot-close"></span>
            <span class="terminal-dot terminal-dot-minimize"></span>
            <span class="terminal-dot terminal-dot-maximize"></span>
        </div>
        <div class="terminal-masthead-title">
            <span class="terminal-prompt" aria-hidden="true">&gt;_</span>
            <span class="terminal-name">monitoring console</span>
            <span class="terminal-live">
                <span class="terminal-pulse" aria-hidden="true"></span>
                LIVE
            </span>
        </div>
    </div>

    @if (method_exists($this, 'filtersForm'))
        {{ $this->filtersForm }}
    @endif

    <x-filament-widgets::widgets
        :columns="$this->getColumns()"
        :data="
            [
                ...(property_exists($this, 'filters') ? ['filters' => $this->filters] : []),
                ...$this->getWidgetData(),
            ]
        "
        :widgets="$this->getVisibleWidgets()"
    />
</x-filament-panels::page>
