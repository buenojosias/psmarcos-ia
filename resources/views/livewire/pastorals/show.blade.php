<div class="space-y-4">
    <h2>{{ $this->pastoral->name }}</h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
            <x-ts-card header="Sobre">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <p class="mb-4">
                            <strong>Coordenador(a)</strong><br>
                            {{ $this->pastoral->user->name ?? 'Coordenador(a) não informado(a)' }}
                        </p>
                        <p>
                            <strong>Comunidade</strong><br>
                            {{ $this->pastoral->community->name ?? 'Comunidade não informada' }}
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <strong>Descrição</strong><br>
                        {{ $this->pastoral->description ?? 'Descrição não disponível' }}
                    </div>
                </div>
                @can('edit', $this->pastoral)
                    <x-slot:footer>
                        <livewire:pastorals.edit :pastoral="$this->pastoral" @saved="$refresh" />
                    </x-slot>
                @endcan
            </x-ts-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mt-4">
                <x-ts-stats title="Perguntas cadastradas" :number="$this->pastoral->questions_count" :href="route('pastorals.questions', $this->pastoral)" />
                <x-ts-stats title="Eventos" :number="$this->pastoral->events_count" :href="route('pastorals.events', $this->pastoral)" />
            </div>
        </div>
        <livewire:notices.list-notices resource="pastoral" :model="$this->pastoral" />
    </div>
</div>
