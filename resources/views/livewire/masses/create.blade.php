<div>
    <x-ts-button text="Adicionar missa" x-on:click="$modalOpen('create-mass-modal')" />
    <x-ts-modal id="create-mass-modal" title="Adicionar missa" size="lg"
        x-on:open="$wire.dispatch('modalOpened')">
        <form id="create-mass-form" wire:submit="save" class="space-y-4">
            <x-ts-select.native label="Comunidade *" wire:model="community_id" :options="$communities" select="label:name|value:id" />
            <div class="grid grid-cols-2 gap-4">
                <x-ts-select.native label="Dia da semana *" wire:model="weekday" :options="$weekdays" select="label:label|value:value" />
                <x-ts-time label="Hora *" type="time" wire:model="time" format="24" :step-minute="15" />
            </div>
            <x-ts-textarea label="Observação" wire:model="note" maxlength="255" count />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-mass-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" loading="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-mass-modal');
        });
    </script>
@endscript
