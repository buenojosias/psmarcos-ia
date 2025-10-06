<div class="space-y-4">
    <div class="flex justify-between gap-4 items-end">
        <div class="flex items-center gap-2">
            <x-ts-select.native label="Quantidade por página" wire:model.live="quantity" :options="[5, 10, 25, 50, 100]" />
            <x-ts-select.native label="Tipo de sugestão" wire:model.live="type" :options="[
                ['value' => '', 'label' => 'Todos'],
                ['value' => 'C', 'label' => 'Comunidade'],
                ['value' => 'P', 'label' => 'Grupo, movimento e pastoral'],
                ['value' => 'E', 'label' => 'Evento'],
                ['value' => 'G', 'label' => 'Geral'],
            ]" />
        </div>
        <div class="flex items-center gap-2">
            <livewire:questions.create-suggestion @saved="$refresh" />
        </div>
    </div>
    <x-ts-table :$headers :$rows paginate selectable wire:model="selected" loading>
        @interact('column_action', $row)
            xxx
        @endinteract
    </x-ts-table>
</div>
