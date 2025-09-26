<div>
    <x-ts-button text="Editar" x-on:click="$modalOpen('edit-pastoral-modal')" />
    <x-ts-modal id="edit-pastoral-modal" title="Editar" size="lg"
        x-on:open="$wire.dispatch('modalOpened')">
        <form id="edit-pastoral-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" required />
            <x-ts-select.native wire:key="community-select-{{ $this->pastoral->id }}-{{ $community_id }}" label="Comunidade" wire:model="community_id" :options="$communities" select="label:name|value:id" />
            <x-ts-select.native wire:key="user-select-{{ $this->pastoral->id }}-{{ $user_id }}" label="Coordenador(a)" wire:model="user_id" :options="$users" select="label:name|value:id" />
            <x-ts-textarea label="Descrição" wire:model="description" required resize-auto />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-pastoral-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('edit-pastoral-modal');
        });
    </script>
@endscript
