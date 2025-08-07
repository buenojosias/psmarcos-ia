<div class="space-y-4">
    <livewire:pastorals.create @saved="$refresh" />
    <x-ts-table :$headers :$rows>
        @interact('column_action', $row)
            <x-ts-link :href="route('pastorals.show', $row)" icon="eye" />
        @endinteract
    </x-ts-table>
</div>
