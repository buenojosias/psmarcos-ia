<div class="space-y-4">
    <h2>{{ $this->event->name }}</h2>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="sm:col-span-2">
            <x-ts-card header="Sobre">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    <div>
                        <p class="mb-4">
                            <strong>{{ $this->event->ends_at ? 'Início' : 'Data' }}</strong><br>
                            {{ Carbon\Carbon::parse($this->event->starts_at)->format('d/m/Y') }}
                        </p>
                        @if ($this->event->ends_at)
                            <p class="mb-4">
                                <strong>Encerramento</strong><br>
                                {{ $this->event->ends_at ? Carbon\Carbon::parse($this->event->ends_at)->format('d/m/Y') : 'Data não informada' }}
                            </p>
                        @endif
                        <p class="mb-4">
                            <strong>Local</strong><br>
                            {{ $this->event->location ?? 'Local não informado' }}
                        </p>
                        <p>
                            <strong>Organizador</strong><br>
                            {{ $this->event->eventable->name ?? 'Não informado' }}
                        </p>
                    </div>
                    <div class="sm:col-span-2">
                        <strong>Descrição</strong><br>
                        {{ $this->event->description ?? 'Descrição não disponível' }}
                    </div>
                </div>
                <x-slot:footer>
                    <livewire:events.edit :event="$this->event" @saved="$refresh" />
                </x-slot>
            </x-ts-card>
        </div>
        <livewire:notices.list-notices resource="event" :model="$this->event" />
        {{-- <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        <x-ts-stats title="Perguntas cadastradas" :number="$this->event->questions_count" :href="route('pastorals.questions', $this->event)" />
        <x-ts-stats title="Eventos" :number="$this->event->events_count" :href="route('pastorals.events', $this->event)" />
        <x-ts-stats title="Avisos" :number="100" />
    </div> --}}
    </div>
</div>
