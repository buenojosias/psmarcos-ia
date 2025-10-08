<div>
    <x-ts-button text="Alterar" x-on:click="$modalOpen('edit-roles-modal')" />
    <x-ts-modal id="edit-roles-modal" title="Editar funções do usuário" size="sm">
        <form id="edit-roles-form" wire:submit="save" class="space-y-4">
            @foreach ($roles as $role)
                <x-ts-checkbox :value="$role->value" :label="$role->getLabel()" :id="'role_' . $role->value" wire:model="selectedRoles" />
            @endforeach
        </form>
        <x-slot name="footer">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-roles-modal')" color="secondary" />
            <x-ts-button text="Salvar" type="submit" form="edit-roles-form" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('edit-roles-modal');
        });
    </script>
@endscript
