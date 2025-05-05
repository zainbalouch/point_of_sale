<x-filament-widgets::widget>
    <x-filament::section>
        <div class="mb-4">
            <form wire:submit="filter">
                {{ $this->form }}
            </form>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 2xl:grid-cols-11">
            @foreach ($metrics as $metric)
                <div class="flex items-center gap-4 p-4 bg-white rounded-lg shadow dark:bg-gray-800">
                    <div class="p-3 text-primary-500 bg-primary-50 rounded-lg dark:bg-primary-900/50">
                        <x-dynamic-component :component="$metric['icon']" class="w-6 h-6" />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ $metric['label'] }}
                        </p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $metric['value'] }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        @if (method_exists($this, 'getFooter'))
            <div class="mt-4">
                {{ $this->getFooter() }}
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
