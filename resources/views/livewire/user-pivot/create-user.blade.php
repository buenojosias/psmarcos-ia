<div>
    <x-ts-modal id="create-user-modal" title="Cadastrar e vincular usuário" size="lg">
        <form id="create-user-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" />
            <x-ts-input label="E-mail *" wire:model="email" />
            <x-ts-password label="Senha *" wire:model="password" generator :rules="['min:8', 'numbers', 'mixed']" />
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
