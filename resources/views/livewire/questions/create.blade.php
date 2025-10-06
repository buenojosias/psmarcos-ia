<x-ts-card class="space-y-4" header="Adicionar perguntas">
    <x-ts-error />
    <x-ts-label class="m-2" label="Dica: Você pode colocar ## (duplo jogo
            da velha) no lugar do nome." />
    @forelse ($questions as $index => $question)
        <div class="p-3 rounded-md bg-gray-200 dark:bg-gray-800 space-y-3" bordered>
            <div class="flex-1 space-y-2">
                <x-ts-input label="Pergunta {{ $index + 1 }}" placeholder="Pergunta {{ $index + 1 }}"
                    wire:model="questions.{{ $index }}.question" />
                <x-ts-textarea label="Resposta {{ $index + 1 }}" placeholder="Resposta {{ $index + 1 }}"
                    wire:model="questions.{{ $index }}.answer" resize-auto />
            </div>
            <div class="flex justify-between">
                <x-ts-button text="Salvar" icon="check" wire:click="saveQuestion('{{ $question['id'] }}')" sm />
                <x-ts-button text="Excluir" icon="trash" wire:click="removeQuestion('{{ $question['id'] }}')" color="red"
                    sm />
            </div>
        </div>
    @empty
    @endforelse
    <x-slot:footer>
        <div class="flex space-x-2">
            <x-ts-button text="Adicionar pergunta" wire:click="addQuestion" sm />
            <livewire:questions.generate-suggestions :resource="$resource" :model="$model" />
        </div>
    </x-slot>
</x-ts-card>
