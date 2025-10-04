<div>
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-1/2">
            <div class="space-y-4">
                <x-ts-card header="Missas" class="space-y-4">
                    @forelse ($community->masses as $mass)
                        {{-- <div class="mb-2 pb-2 border-b border-gray-200 dark:border-gray-600 last:border-none last:mb-0 last:pb-0"> --}}
                        <div class="">
                            <p class="font-semibold">{{ $mass->weekday->getLabel() }} - {{ $mass->time->format('H:i') }}
                            </p>
                            @if ($mass->note)
                                <p class="text-sm">{{ $mass->note }}</p>
                            @endif
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Nenhuma missa cadastrada.</p>
                    @endforelse
                    <x-slot:footer>
                        <x-ts-button text="Gerenciar missas" :href="route('masses.index')" sm />
                    </x-slot>
                </x-ts-card>
            </div>
        </div>
        <div class="w-full sm:w-1/2">
            <div class="space-y-4">
                <x-ts-card header="Avisos">

                    <x-slot:footer>
                        <x-ts-button text="Gerenciar avisos" href="#" sm />
                    </x-slot>
                </x-ts-card>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <x-ts-stats title="Grupos, Movimentos e Pastorais" :number="$community->pastorals_count" />
                    <x-ts-stats title="Eventos" :number="$community->events_count" />
                </div>
            </div>
        </div>
    </div>
