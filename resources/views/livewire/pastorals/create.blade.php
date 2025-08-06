<div>
    <x-ts-button text="Adicionar novo" x-on:click="$modalOpen('create-group-modal')" />
    <x-ts-modal id="create-group-modal" title="Adicionar grupo, movimento ou pastoral" size="lg">
        <form id="create-group-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome" name="name" required />
            <x-ts-input label="Descrição" name="description" required />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-group-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
