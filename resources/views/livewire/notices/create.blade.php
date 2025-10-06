<div>
    <x-ts-button text="Adicionar aviso" x-on:click="$modalOpen('create-notice-modal')" />
    <x-ts-modal id="create-notice-modal" title="Adicionar aviso" size="lg"
        x-on:open="$wire.dispatch('modalOpened')">
        <form id="create-notice-form" wire:submit="save" class="space-y-4">
            <x-ts-textarea label="Descrição *" wire:model="content" maxlength="255" count required />
            <x-ts-date wire:model="expires_at" label="Válido até *" format="DD/MM/YYYY" :min-date="now()->addDay()" hint="O aviso será excluído após esta data" required />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-notice-modal')" color="secondary" />
            <x-ts-button text="Salvar" wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-notice-modal');
        });
    </script>
@endscript
