<div class="space-y-4">
    <x-ts-banner text="Criar funções de embed" color="red" />
    <h2>{{ $community->name }}</h2>
    <div class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-1/2">
            <div class="space-y-4">
                <x-ts-card header="Sobre" class="detail">
                    <x-detail label="Nome" :value="$community->name" />
                    <x-detail label="Abreviação" :value="$community->alias" />
                    <x-detail label="Endereço" :value="$community->address ?? 'Não informado'" />
                    @can('edit', $community)
                        <x-slot:footer>
                            <x-ts-button text="Editar" />
                        </x-slot>
                    @endcan
                </x-ts-card>
                <x-ts-card header="Missas" class="space-y-4">
                    @forelse ($community->masses as $mass)
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
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <x-ts-stats title="Grupos, Movimentos e Pastorais" :number="$community->pastorals_count" :href="route('communities.pastorals', $community)" />
                    <x-ts-stats title="Eventos" :number="$community->events_count" :href="route('communities.events', $community)" />
                </div>
                <x-ts-card>
                    <a href="{{ route('communities.questions', $community) }}">Perguntas e respostas</a>
                </x-ts-card>
                <livewire:user-pivot.list-users resource="communities" :model="$community" />
            </div>
        </div>
    </div>
