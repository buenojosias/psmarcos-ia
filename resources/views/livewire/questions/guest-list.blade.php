<div class="flex justify-center">
    <div class="w-full md:w-10/12">
        <x-ts-card>
            @if (!$questions || $questions->isEmpty())
                <p class="text-center text-gray-600 font-semibold py-6">Nenhuma pergunta e resposta adicionada.</p>
            @else
                <ul class="divide-y">
                    @foreach ($questions as $question)
                        <li x-data="{ expanded: false }" class="py-3 space-y-1">
                            <div @click="expanded = !expanded"
                                class="flex justify-between cursor-pointer font-semibold gap-4">
                                <span class="text-gray-700 dark:text-gray-300">{{ $question->question }}</span>
                                <x-ts-icon name="chevron-down" class="w-5 h-5 transition"
                                    x-bind:class="expanded ? 'rotate-180' : ''" />
                            </div>
                            <div x-show="expanded" x-collapse class="text-gray-600 dark:text-gray-400 pr-8">
                                {{ $question->answer }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <x-slot:footer>
                <x-ts-button text="Fazer uma pergunta" flat sm />
            </x-slot:footer>
        </x-ts-card>
    </div>
</div>
