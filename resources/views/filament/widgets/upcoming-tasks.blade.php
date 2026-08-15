<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Upcoming tasks
        </x-slot>
        <x-slot name="description">
            What needs attention on the farm
        </x-slot>

        @php($tasks = $this->getTasks())

        <div class="space-y-3">
            @forelse ($tasks as $task)
                <div class="flex items-center gap-3">
                    <x-filament::badge :color="$task['color']" size="sm">
                        {{ $task['kind'] }}
                    </x-filament::badge>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-gray-950 dark:text-white">
                            {{ $task['title'] }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $task['date']->format('D, j M Y') }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Nothing on the horizon — you're all caught up.
                </p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
