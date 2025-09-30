<div>
    <x-ts-button text="Cadastrar evento" x-on:click="$modalOpen('create-event-modal')" />
    <x-ts-modal id="create-event-modal" title="Cadastrar evento" size="lg"
        x-on:open="$wire.dispatch('modalOpened')">
        <form id="create-event-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" required />
            <div class="grid grid-cols-2 gap-4">
                <x-ts-date wire:model="start_date" label="Data de início *" format="DD/MM/YYYY" :min-date="now()" />
                <x-ts-time wire:model="start_time" label="Hora de início *" format="24" :step-minute="5" />
                <x-ts-date wire:model="end_date" label="Data de término" format="DD/MM/YYYY" :min-date="now()" />
                <x-ts-time wire:model="end_time" label="Hora de término" format="24" :step-minute="5" />
            </div>
            <x-ts-input label="Local" wire:model="location" />
            <x-ts-textarea label="Descrição" wire:model="description" />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-event-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-event-modal');
        });
    </script>
@endscript
