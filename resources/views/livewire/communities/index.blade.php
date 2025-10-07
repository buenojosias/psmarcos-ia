<div>
    <livewire:communities.create @saved="$refresh" />
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-4">
        @foreach ($this->communities as $community)
            <x-ts-card header="{{ $community->name }}">
                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-3 font-semibold">
                    <div>Pastorais</div>
                    <div>{{ $community->pastorals_count }}</div>
                </div>
                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-3 font-semibold">
                    <div>Eventos</div>
                    <div>{{ $community->events_count }}</div>
                </div>
                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-3 font-semibold">
                    <div>Perguntas e respostas</div>
                    <div>{{ $community->questions_count }}</div>
                </div>
                <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 font-semibold">
                    <div>Avisos</div>
                    <div>{{ $community->notices_count }}</div>
                </div>
                <x-slot:footer>
                    <x-ts-button text="Detalhes" href="{{ route('communities.show', $community) }}" flat />
                </x-slot>
            </x-ts-card>
        @endforeach
    </div>
</div>
