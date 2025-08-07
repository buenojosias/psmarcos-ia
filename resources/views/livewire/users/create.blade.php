<div>
    <x-ts-button text="Cadastrar usuário" x-on:click="$modalOpen('create-user-modal')" />
    <x-ts-modal id="create-user-modal" title="Cadastrar usuário" size="lg">
        <form id="create-user-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome" wire:model="name" required />
            <x-ts-select.native label="Função" wire:model="role" required
                :options="$roles" select="label:label|value:value"
            />
            <x-ts-input label="E-mail" wire:model="email" required />
            <x-ts-password label="Senha" wire:model="password" />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('create-user-modal')" color="secondary" />
            <x-ts-button text="Salvar" type="submit" form="create-user-form" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-user-modal');
        });
    </script>
@endscript
