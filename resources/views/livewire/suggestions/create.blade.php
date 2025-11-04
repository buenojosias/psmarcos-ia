<div>
    <x-ts-button text="Adicionar sugestão" x-on:click="$modalOpen('create-suggestion-modal')" />
    <x-ts-modal id="create-suggestion-modal" title="Adicionar sugestão de pergunta" size="md">
        <form id="create-suggestion-form" wire:submit="save" class="space-y-4">
            <x-ts-select.native label="Tipo de sugestão *" wire:model="type" :options="[
                ['value' => '', 'label' => 'Selecione o tipo'],
                ['value' => 'C', 'label' => 'Comunidade'],
                ['value' => 'P', 'label' => 'Grupo, movimento e pastoral'],
                ['value' => 'E', 'label' => 'Evento'],
                ['value' => 'G', 'label' => 'Geral'],
            ]" />
            <x-ts-input label="Sugestão de pergunta *" wire:model="content"
                placeholder="Digite a sugestão de pergunta aqui..." hint="Atenção! Coloque ## onde deverá entrar o nome."  />
        </form>
        <x-slot:footer>
            <x-ts-button text="Cancelar" flat x-on:click="$modalClose('create-suggestion-modal')" />
            <x-ts-button text="Salvar sugestão" primary wire:click="save" />
        </x-slot>
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('saved', () => {
            $modalClose('create-suggestion-modal');
        });
    </script>
@endscript
