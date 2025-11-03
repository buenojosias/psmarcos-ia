<div x-data="{ showsuggestions: false }">
    <x-ts-card class="space-y-4" header="Adicionar pergunta">
        <x-ts-label class="m-2" label="Dica: Você pode colocar ## (duplo jogo da velha) no lugar do nome." />
        <x-ts-input label="Pergunta" placeholder="Digite a pergunta" wire:model="question" />
        <x-ts-textarea label="Resposta" placeholder="Digite uma resposta curta para a pergunta" wire:model="answer"
            resize-auto />
        <div class="p-2 bg-gray-100 dark:bg-gray-800 border rounded-lg divide-y text-sm" x-show="showsuggestions" x-transition>
            @foreach ($suggestions as $suggestion)
                <div class="flex justify-between items-center py-2">
                    <span>{{ $suggestion['question'] }}</span>
                    <x-ts-button wire:click="removeSuggestion({{ $suggestion['temp_id'] }})" icon="x-mark" color="red" flat sm />
                </div>
            @endforeach
        </div>
        <x-slot:footer>
            <div class="flex justify-between items-center gap-2">
                <x-ts-button text="Salvar" wire:click="saveQuestion" loading="saveQuestion" />
                <x-ts-dropdown>
                    <x-slot:action>
                        <x-ts-button x-on:click="show = !show" icon="light-bulb" color="secondary" />
                    </x-slot:action>
                    <x-slot:header>
                        <p class="font-semibold">Sugestões de perguntas</p>
                    </x-slot:header>
                    <x-ts-dropdown.items icon="bookmark" text="Perguntas padrão"
                        x-on:click="$modalOpen('default-suggestions')" />
                    <x-ts-dropdown.items icon="sparkles" text="Gerar com IA"
                        x-on:click="$modalOpen('ai-suggestions')" />
                    @if (!empty($suggestions))
                        <x-ts-dropdown.items icon="queue-list" text="Fila de sugestões"
                            x-on:click="showsuggestions = !showsuggestions" divide />
                    @endif
                </x-ts-dropdown>
            </div>
        </x-slot>
    </x-ts-card>
    <livewire:questions.default-suggestions :resource="$resource" :model="$model" />
    <livewire:questions.generate-suggestions :resource="$resource" :model="$model" />
</div>
