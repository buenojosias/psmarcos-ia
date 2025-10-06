<div>
    <x-ts-button text="Sugestões de perguntas" x-on:click="$modalOpen('default-suggestions')" icon="light-bulb" sm />
    <x-ts-modal title="Sugestões de perguntas" id="default-suggestions" max-width="2xl"
        x-on:open="$wire.loadSuggestions()">
        <ul>
            @foreach ($suggestions as $index => $suggestion)
                <li class="py-1 flex justify-between items-center border-b border-gray-200">
                    <span class="text-gray-700 dark:text-gray-300">{{ $suggestion['content'] }}</span>
                    <div class="flex items-center">
                        <x-ts-button icon="plus-circle" wire:click="addSuggestion('{{ $index }}')" flat />
                        <x-ts-button icon="minus-circle" wire:click="removeSuggestion('{{ $index }}')" flat
                            color="secundary" />
                    </div>
                </li>
            @endforeach
        </ul>
        <x-ts-loading />
    </x-ts-modal>
</div>
@script
    <script>
        $wire.on('closeModal', () => {
            $modalClose('question-suggestions');
        });
    </script>
@endscript
