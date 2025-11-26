<div>
    <x-ts-button text="Editar" x-on:click="$modalOpen('edit-service-modal')" />
    <x-ts-modal id="edit-service-modal" title="Editar" size="lg">
        <form id="edit-service-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" required />
            <x-ts-textarea label="Descrição" wire:model="description" required resize-auto />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-service-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('edit-service-modal');
        });
    </script>
@endscript
