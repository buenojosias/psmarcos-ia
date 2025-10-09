<div>
    <x-ts-modal id="attach-user-modal" title="Vincular usuário à pastoral" size="sm"
        x-on:open="$wire.dispatch('load-users')">
        <x-ts-select.styled label="Selecionar usuário(a)" wire:model="user_id" searchable :options="$users"
            select="label:name|value:id">
            <x-slot:after>
                <div class="p-2 flex flex-col justify-center items-center">
                    Usuário não encontrado
                    <x-ts-button text="Criar usuário" x-on:click="$modalClose('attach-user-modal'); $modalOpen('create-user-modal')" />
                </div>
            </x-slot:after>
        </x-ts-select.styled>
        <x-slot:footer class="flex gap-2">
            <x-ts-button text="Cancelar" theme="secondary" x-on:click="$modalClose('attach-user-modal')" flat />
            <x-ts-button text="Vincular" wire:click="attach" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('attached', () => {
            $modalClose('attach-user-modal');
        });
    </script>
@endscript
