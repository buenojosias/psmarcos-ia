<div>
    <x-ts-modal id="edit-mass-modal" title="Editar missa" size="lg">
        <form id="edit-mass-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Comunidade" wire:model="community_name" title="Não é possível alterar" readonly />
            <div class="grid grid-cols-2 gap-4">
                {{-- <x-ts-select.native label="Dia da semana *" wire:model="weekday" :options="$weekdays" select="label:label|value:value" /> --}}
                <x-ts-input label="Dia da semana" wire:model="weekday" title="Não é possível alterar" readonly />
                <x-ts-time label="Hora *" type="time" wire:model="time" format="24" :step-minute="15" />
            </div>
            <x-ts-textarea label="Observação" wire:model="note" maxlength="255" count />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-mass-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" loading="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('open-modal', () => {
            $modalOpen('edit-mass-modal');
        });
        $wire.on('saved', () => {
            $modalClose('edit-mass-modal');
        });
    </script>
@endscript
