<div class="space-y-4">
    <h2>{{ $this->service->name }}</h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        <div class="sm:col-span-2">
            <x-ts-card header="Sobre">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <strong>Descrição</strong><br>
                        {{ $this->service->description ?? 'Descrição não adicionada' }}
                    </div>
                </div>
                {{-- @can('edit', $this->pastoral)
                    <x-slot:footer>
                        <livewire:pastorals.edit :pastoral="$this->pastoral" @saved="$refresh" />
                    </x-slot>
                @endcan --}}
            </x-ts-card>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mt-4">
                <x-ts-stats title="Perguntas cadastradas" :number="$this->service->questions_count" :href="route('services.questions', $this->service)" />
                <x-ts-stats title="Eventos" :number="$this->service->events_count" :href="route('services.events', $this->service)" />
            </div>
        </div>
        <div class="space-y-4">
            <livewire:notices.list-notices resource="service" :model="$this->service" />
        </div>
    </div>
</div>
