<div class="p-3 rounded-md bg-gray-200 flex flex-row gap-4" bordered>
    <div class="flex-1 space-y-2">
        <x-ts-input label="Pergunta {{ $index + 1 }}" placeholder="Pergunta {{ $index + 1 }}" />
        <x-ts-textarea label="Resposta {{ $index + 1 }}" placeholder="Resposta {{ $index + 1 }}" resize-auto />
    </div>
    <div class="flex flex-col justify-end items-end gap-2">
        <x-ts-button icon="check" round sm />
        <x-ts-button icon="trash" wire:click="removeQuestion('{{ $question['id'] }}')" color="red" round sm />
    </div>
</div>
