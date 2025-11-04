<div class="space-y-4">
    <h2 class="flex items-center gap-2">
        <a href="{{ route('pastorals.show', $this->pastoral) }}">
            <x-ts-icon name="arrow-left" class="w-4 h-4 text-gray-700 dark:text-gray-300" />
        </a>
        {{ $this->pastoral->name }}
    </h2>
    @can('manage', $this->pastoral)
        <div class="grid grid-cols-1 lg:grid-cols-2 sm:grid-reverse gap-4">
            <div>
                <livewire:questions.create resource="pastoral" :model="$this->pastoral" />
            </div>
            <div>
                <livewire:questions.questions-list resource="pastoral" :model="$this->pastoral" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="pastoral" :model="$this->pastoral" />
    @endcan
</div>
