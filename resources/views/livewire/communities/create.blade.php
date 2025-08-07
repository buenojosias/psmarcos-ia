<div>
    <x-ts-button text="Adicionar nova" x-on:click="$modalOpen('create-community-modal')" />
    <x-ts-modal id="create-community-modal" title="Adicionar comunidade" size="lg">
        <form id="create-community-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome" wire:model="name" required />
            <x-ts-input label="Abreviação" wire:model="alias" required />
            <x-ts-input label="Endereço" wire:model="address" />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-community-modal')" color="secondary" />
            <x-ts-button text="Salvar" type="submit" form="create-community-form" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-community-modal');
        });
    </script>
@endscript
