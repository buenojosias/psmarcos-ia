<div class="space-y-4">
    <div class="flex justify-between gap-4 items-end">
        <x-ts-select.native label="Quantidade por página" wire:model.live="quantity" :options="[5, 10, 25, 50, 100]" />
        <div class="flex items-center gap-2">
            <x-ts-button text="Adicionar pergunta" />
            <x-ts-button icon="funnel" flat />
        </div>
    </div>
    <x-ts-table :$headers :$rows paginate selectable wire:model="selected" loading>
        @interact('column_qa', $row)
            <div class="!text-wrap">
                <strong>{{ $row->question }}</strong><br>
                {{ $row->answer }}
            </div>
        @endinteract
        @interact('column_v', $row)
            <a href="{{ route($row->route_name . '.questions', $row->questionable->id) }}">{{ $row->questionable->name }}</a>
        @endinteract
        @interact('column_action', $row)
            <x-ts-icon :name="$row->status->getIcon()" :color="$row->status->getColor()" class="w-5 mx-2" outline />
            {{-- <x-ts-button href="{{ route('questions.edit', $row->id) }}" icon="pencil" sm flat /> --}}
            {{-- <x-ts-button wire:click="confirm('delete', {{ $row->id }})" icon="trash" sm flat negative /> --}}
        @endinteract
    </x-ts-table>
</div>
