<div class="space-y-4">
    {{-- <livewire:notices.create @saved="$refresh" /> --}}
    <x-ts-table :$headers :$rows>
        @interact('column_notice_content', $row)
            <p class="!text-wrap">{{ $row->content }}</p>
        @endinteract
        @interact('column_action', $row)
            <x-ts-dropdown icon="ellipsis-vertical">
                <x-ts-dropdown.items x-on:click="$dispatch('delete-notice', { notice: {{ $row['id'] }} })">Excluir</x-ts-dropdown.item>
            </x-ts-dropdown>
        @endinteract
    </x-ts-table>
    <livewire:notices.delete @deleted="$refresh" />
</div>
