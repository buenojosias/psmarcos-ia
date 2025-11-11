<div>
    <x-ts-card header="Perguntas e respostas (Q&A)">
        <ul class="space-y-2">
            @forelse ($this->questions as $item)
                <li
                    class="bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-900 flex flex-row p-2 rounded-md">
                    <div class="pl-1 pr-2 flex items-center">
                        @if ($item['status']->value == 'pending')
                            <x-ts-checkbox wire:model="selectedQuestions" id="question-{{ $item['id'] }}"
                                value="{{ $item['id'] }}" />
                        @endif
                    </div>
                    <div class="flex-1 text-sm">
                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $item['question'] }}</span> <br>
                        {{ $item['answer'] }}
                    </div>
                    <div class="p-2 flex flex-col md:flex-row items-center justify-center gap-2">
                        <x-ts-icon :name="$item['status']->getIcon()" outline :color="$item['status']->getColor()" class="w-5 h-5" />
                        <x-ts-dropdown icon="ellipsis-vertical" static>
                            <x-ts-dropdown.items icon="pencil" text="Editar"
                                x-on:click="$dispatch('edit-question', { question: {{ $item['id'] }} })" />
                            <x-ts-dropdown.items icon="trash" text="Excluir"
                                wire:click="delete({{ $item['id'] }})" />
                        </x-ts-dropdown>
                    </div>
                </li>
            @empty
                <li class="text-center text-gray-500 dark:text-gray-400">Nenhuma pergunta cadastrada.</li>
            @endforelse
        </ul>
        @can('vectorize')
            <x-slot:footer>
                <x-ts-button wire:click="vectorize" text="Treinar agente" :disabled="$vectorizing" sm />
                {{-- <x-ts-button wire:click="deleteSelected" text="Excluir selecionadas" color="red" :disabled="$vectorizing" sm /> --}}
            </x-slot>
        @endcan
    </x-ts-card>
    <livewire:questions.edit :model="$model" @saved="$refresh" />
</div>
