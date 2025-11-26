<div>
    <x-ts-modal id="create-service-modal" title="Adicionar serviço" size="lg">
        <form id="create-service-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" required />
            <x-ts-textarea label="Descrição" wire:model="description" required resize-auto />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-service-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-service-modal');
        });
    </script>
@endscript
