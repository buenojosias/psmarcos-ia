<div>
    <x-ts-card header="Perguntas e respostas (Q&A)">
        <ul class="space-y-2">
            @foreach ($this->questions as $item)
                <li class="bg-gray-100 hover:bg-gray-200 flex flex-row p-2 rounded-md">
                    <div class="pl-1 pr-2 flex items-center">
                        @if ($item['status']->value == 'pending')
                            <x-ts-checkbox wire:model="selectedQuestions" value="{{ $item['id'] }}" />
                        @endif
                    </div>
                    <div class="flex-1">
                        <span class="font-semibold text-gray-700">{{ $item['question'] }}</span> <br>
                        {{ $item['answer'] }}
                    </div>
                    <div class="p-2 flex items-center justify-center gap-1">
                        <x-ts-icon :name="$item['status']->getIcon()" outline :color="$item['status']->getColor()" class="w-5 h-5" />
                        <x-ts-dropdown icon="ellipsis-vertical" static>
                            <x-ts-dropdown.items icon="pencil" text="Editar" />
                            <x-ts-dropdown.items icon="trash" text="Excluir" />
                        </x-ts-dropdown>
                    </div>
                </li>
            @endforeach
        </ul>
        <x-slot:footer>
            <x-ts-button wire:click="vectorize" text="Treinar agente" sm />
            <x-ts-button wire:click="deleteSelected" text="Excluir selecionadas" color="red" flat sm />
        </x-slot>
    </x-ts-card>
</div>
