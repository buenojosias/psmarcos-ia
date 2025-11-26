<div class="space-y-4">
    <h2 class="flex items-center gap-2">
        <a href="{{ route('services.show', $this->service) }}">
            <x-ts-icon name="arrow-left" class="w-4 h-4 text-gray-700 dark:text-gray-300" />
        </a>
        {{ $this->service->name }}
    </h2>
    @can('manage', $service)
        <livewire:events.create :model="$this->service" @saved="$refresh" />
    @endcan
    <x-ts-table :$headers :$rows>
        @interact('column_event_name', $row)
            <a href="{{ route('events.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_action', $row)
            <x-ts-link :href="route('events.questions', $row)" icon="question-mark-circle" />
        @endinteract
    </x-ts-table>
</div>
