<div>
    <x-ts-button text="Adicionar novo" x-on:click="$modalOpen('create-pastoral-modal')" />
    <x-ts-modal id="create-pastoral-modal" title="Adicionar grupo, movimento ou pastoral" size="lg"
        x-on:open="$wire.dispatch('modalOpened')">
        <form id="create-pastoral-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" required />
            @if (!empty($communities))
                <x-ts-select.native label="Comunidade" wire:model="community_id" wire:key="{{ now() }}" :options="$communities"
                    select="label:name|value:id" />
            @endif
            <x-ts-select.native label="Usuário" wire:model="user_id" :options="$users"
                select="label:name|value:id" />
            <x-ts-textarea label="Descrição" wire:model="description" required resize-auto />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-pastoral-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-pastoral-modal');
        });
    </script>
@endscript
