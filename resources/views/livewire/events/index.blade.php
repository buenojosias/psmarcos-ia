<div class="space-y-4">
    <livewire:events.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        @interact('column_event_name', $row)
            <a href="{{ route('events.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_action', $row)
            <x-ts-link :href="route('events.questions', $row)" icon="question-mark-circle" />
        @endinteract
    </x-ts-table>
</div>
