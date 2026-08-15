<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Recent activity
        </x-slot>
        <x-slot name="description">
            Latest records from across the farm
        </x-slot>

        @php($activity = $this->getActivity())

        <div class="space-y-4">
            @forelse ($activity as $item)
                <div class="flex items-center gap-3">
                    <span class="rounded-full bg-gray-100 p-2 dark:bg-white/5">
                        <x-filament::icon :icon="$item['icon']" class="h-4 w-4 text-gray-500 dark:text-gray-400" />
                    </span>
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-gray-950 dark:text-white">
                            {{ $item['title'] }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $item['detail'] }}
                        </p>
                    </div>
                    <span class="shrink-0 text-xs text-gray-500 dark:text-gray-400">
                        {{ $item['date']->format('j M') }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    No activity yet — records you add will show up here.
                </p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
