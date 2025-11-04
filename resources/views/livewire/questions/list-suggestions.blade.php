<div class="space-y-4">
    <div class="flex justify-between gap-4 items-end">
        <div class="flex items-center gap-4">
            <x-ts-select.native label="Quantidade por página" wire:model.live="quantity" :options="[5, 10, 25, 50, 100]" />
            <x-ts-select.native label="Tipo de sugestão" wire:model.live="type" :options="$types" />
        </div>
        <div class="flex items-center gap-2">
            <livewire:questions.create-suggestion @saved="$refresh" />
        </div>
    </div>
    <x-ts-table :$headers :$rows paginate loading>
        @interact('column_action', $row)
            <x-ts-button x-on:click="$dispatch('edit-suggestion', { suggestion: {{ $row->id }} })" icon="pencil" sm flat />
            <x-ts-button x-on:click="$dispatch('delete-suggestion', { suggestion: {{ $row->id }} })" icon="trash" color="red" sm flat />
        @endinteract
    </x-ts-table>
    <livewire:questions.edit-suggestion @saved="$refresh" />
    <livewire:questions.delete-suggestion @deleted="$refresh" />
</div>
