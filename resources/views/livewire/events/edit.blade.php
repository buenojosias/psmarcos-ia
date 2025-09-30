<div>
    <div class="flex space-x-2">
        <x-ts-button text="Editar" x-on:click="$modalOpen('edit-event-modal')" />
        <x-ts-button text="Perguntas e respostas" :href="route('events.questions', $this->event)" color="secondary" />
    </div>

    <x-ts-modal id="edit-event-modal" title="Editar" size="lg">
        <form id="edit-event-form" wire:submit="save" class="space-y-4">
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
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-event-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('edit-event-modal');
        });
    </script>
@endscript
