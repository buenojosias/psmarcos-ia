<div class="space-y-4">
    <livewire:masses.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        {{-- @interact('column_event_name', $row)
            <a href="{{ route('events.show', $row) }}">{{ $row->name }}</a>
        @endinteract --}}
        @interact('column_action', $row)
            <x-ts-dropdown icon="ellipsis-vertical">
                <x-ts-dropdown.items x-on:click="$dispatch('delete-mass', { mass: {{ $row['id'] }} })">Delete</x-ts-dropdown.item>
            </x-ts-dropdown>
        @endinteract
    </x-ts-table>
    <livewire:masses.delete @deleted="$refresh" />
</div>
