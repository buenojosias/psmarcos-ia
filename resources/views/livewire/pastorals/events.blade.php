<div class="space-y-4">
    <h2>{{ $pastoral->name }}</h2>
    @can('manage', $pastoral)
        <livewire:events.create :model="$this->pastoral" @saved="$refresh" />
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
