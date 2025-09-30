<div class="space-y-4">
    <livewire:events.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        @interact('column_event_name', $row)
            <a href="{{ route('events.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_action', $row)
            {{-- <x-ts-link :href="route('pastorals.questions', $row)" icon="question-mark-circle" /> --}}
            <x-ts-icon name="question-mark-circle" class="w-4" />
        @endinteract
    </x-ts-table>
</div>
