<div>
    <x-ts-modal id="edit-suggestion-modal" title="Editar sugestão de pergunta" size="md">
        <form id="edit-suggestion-form" wire:submit="save" class="space-y-4">
            <x-ts-select.native label="Tipo de sugestão *" wire:model="type" :options="[
                ['value' => '', 'label' => 'Selecione o tipo'],
                ['value' => 'C', 'label' => 'Comunidade'],
                ['value' => 'P', 'label' => 'Grupo, movimento e pastoral'],
                ['value' => 'E', 'label' => 'Evento'],
                ['value' => 'G', 'label' => 'Geral'],
            ]" :disabled="$suggestion && $suggestion->usages > 0" />
            <x-ts-input label="Sugestão de pergunta *" wire:model="content"
                placeholder="Digite a sugestão de pergunta aqui..." hint="Atenção! Coloque ## onde deverá entrar o nome."  />
        </form>
        <x-slot:footer>
            <x-ts-button text="Cancelar" flat x-on:click="$modalClose('edit-suggestion-modal')" />
            <x-ts-button text="Salvar" primary wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('open-modal', () => {
            $modalOpen('edit-suggestion-modal');
        });
        $wire.on('saved', () => {
            $modalClose('edit-suggestion-modal');
        });
    </script>
@endscript
