<div>
    <x-ts-button text="Editar" x-on:click="$modalOpen('edit-user-modal')" />
    <x-ts-modal id="edit-user-modal" title="Editar usuário" size="lg">
        <form id="edit-user-form" wire:submit="save" class="space-y-4">
            <x-ts-input label="Nome *" wire:model="name" />
            <x-ts-input label="E-mail *" wire:model="email" />
            <x-ts-password label="Senha" wire:model="password" generator :rules="['min:8', 'numbers', 'mixed']" hint="Informe uma nova senha se quiser alterá-la" />
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-user-modal')" color="secondary" />
            <x-ts-button text="Salvar" type="submit" form="edit-user-form" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('edit-user-modal');
        });
    </script>
@endscript
