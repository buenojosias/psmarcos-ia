<div class="space-y-4">
    @can('create', App\Models\Event::class)
        <livewire:events.create @saved="$refresh" />
    @endcan
    <x-ts-table :$headers :$rows>
        @interact('column_event_name', $row)
            <a href="{{ route('events.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_v', $row)
            @if ($row->eventable)
                <a href="{{ route($row->route_name . '.show', $row->eventable->id) }}">{{ $row->eventable->name }}</a>
            @endif
        @endinteract
        @interact('column_action', $row)
            <x-ts-link :href="route('events.questions', $row)" icon="question-mark-circle" />
        @endinteract
    </x-ts-table>
</div>
