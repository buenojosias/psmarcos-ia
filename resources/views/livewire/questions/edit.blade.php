<x-ts-modal title="Editar pergunta" id="edit-question-modal" size="lg" x-on:close="$wire.resetFields()">
    <form wire:submit="save" id="edit-question-form" class="space-y-4">
        <x-ts-label class="m-2" label="Dica: Você pode colocar ## (duplo jogo da velha) no lugar do nome." />
        <x-ts-input label="Pergunta" placeholder="Digite a pergunta" wire:model="question" />
        <x-ts-textarea label="Resposta" placeholder="Digite uma resposta curta para a pergunta" wire:model="answer"
            resize-auto />
    </form>
    <x-slot:footer>
        <div class="flex justify-between items-center gap-2">
            <x-ts-button text="Cancelar" x-on:click="$modalClose('edit-question-modal')" color="gray" flat />
            <x-ts-button text="Salvar" type="submit" form="edit-question-form" loading="save" />
        </div>
    </x-slot>
</x-ts-modal>
@script
    <script>
        $wire.on('open-modal', () => {
            $modalOpen('edit-question-modal');
        });
        $wire.on('saved', () => {
            $modalClose('edit-question-modal');
        });
    </script>
@endscript
