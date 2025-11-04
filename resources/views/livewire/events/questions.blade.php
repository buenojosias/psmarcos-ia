<div class="space-y-4">
    <h2 class="flex items-center gap-2">
        <a href="{{ route('events.show', $this->event) }}">
            <x-ts-icon name="arrow-left" class="w-4 h-4 text-gray-700 dark:text-gray-300" />
        </a>
        {{ $this->event->name }}
    </h2>
    @can('manage', $this->event)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <livewire:questions.create resource="event" :model="$this->event" />
            </div>
            <div>
                <livewire:questions.questions-list resource="event" :model="$this->event" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="event" :model="$this->event" />
    @endcan
</div>
