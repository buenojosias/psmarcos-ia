<x-ts-card class="space-y-2" header="Adicionar perguntas" minimize>
    <x-ts-error />
    <x-ts-label class="m-2"
        label="Dica: Você pode colocar ## (duplo jogo
            da velha) no lugar do nome do grupo, movimento ou pastoral." />
    @foreach ($questions as $index => $question)
        {{-- <livewire:pastorals.questions-form :pastoral="$pastoral" :question="$question" :index="$index" /> --}}
        <div class="p-3 rounded-md bg-gray-200 flex flex-row gap-4" bordered>
            <div class="flex-1 space-y-2">
                <x-ts-input label="Pergunta {{ $index + 1 }}" placeholder="Pergunta {{ $index + 1 }}"
                    wire:model="questions.{{ $index }}.question" />
                <x-ts-textarea label="Resposta {{ $index + 1 }}" placeholder="Resposta {{ $index + 1 }}"
                    wire:model="questions.{{ $index }}.answer" resize-auto />
            </div>
            <div class="flex flex-col justify-end items-end gap-2">
                <x-ts-button icon="check" wire:click="saveQuestion('{{ $question['id'] }}')" round sm />
                <x-ts-button icon="trash" wire:click="removeQuestion('{{ $question['id'] }}')" color="red" round
                    sm />
            </div>
        </div>
    @endforeach
    <x-slot:footer>
        <x-ts-button text="Adicionar pergunta" wire:click="addQuestion" sm />
        <livewire:pastorals.generate-question-suggestions :pastoral="$pastoral" />
    </x-slot>
</x-ts-card>
