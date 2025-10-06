<div class="space-y-4">
    <h2>{{ $community->name }}</h2>
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-1/2">
            <div class="space-y-4">
                <x-ts-card header="Sobre" class="space-y-4">
                    <p>
                        <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">Abreviação</span><br />
                        {{ $community->alias }}
                    </p>
                    <p>
                        <span class="font-semibold text-sm text-gray-800 dark:text-gray-200">Endereço</span><br />
                        {{ $community->address ?? 'Não informado' }}
                    </p>
                    <x-slot:footer>
                        <x-ts-button text="Editar" />
                    </x-slot>
                </x-ts-card>


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
                <livewire:notices.list-notices resource="comunidade" :model="$community" />
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <x-ts-stats title="Grupos, Movimentos e Pastorais" :number="$community->pastorals_count" :href="route('communities.pastorals', $community)" />
                    <x-ts-stats title="Eventos" :number="$community->events_count" :href="route('communities.events', $community)" />
                </div>
            </div>
        </div>
    </div>
