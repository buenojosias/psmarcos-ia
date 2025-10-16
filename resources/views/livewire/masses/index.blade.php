<div class="space-y-4">
    @can('create', App\Models\Mass::class)
        <livewire:masses.create @saved="$refresh" />
    @endcan
    <x-ts-table :$headers :$rows>
        @interact('column_note', $row)
            @if ($row['note'])
                <x-ts-tooltip :text="$row['note']" icon="information-circle" />
            @endif
        @endinteract
        @interact('column_action', $row)
            @if((auth()->user()->can('edit', $row) || auth()->user()->can('delete')))
                <x-ts-dropdown icon="ellipsis-vertical">
                    @can('edit', $row)
                        <x-ts-dropdown.items
                            x-on:click="$dispatch('edit-mass', { mass: {{ $row['id'] }} })">Editar</x-ts-dropdown.item>
                    @endcan
                    @can('delete')
                        <x-ts-dropdown.items
                            x-on:click="$dispatch('delete-mass', { mass: {{ $row['id'] }} })">Excluir</x-ts-dropdown.item>
                    @endcan
                </x-ts-dropdown>
            @endif
        @endinteract
    </x-ts-table>
    @hasanyrole(['admin', 'pascom', 'coordinator'])
        <livewire:masses.edit @saved="$refresh" />
    @endhasanyrole
    @can('delete', App\Models\Mass::class)
        <livewire:masses.delete @deleted="$refresh" />
    @endcan
</div>
