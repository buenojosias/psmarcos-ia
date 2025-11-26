<div>
    @can('create', App\Models\Service::class)
        <div class="mb-4">
            <x-ts-button text="Adicionar serviço" x-on:click="$modalOpen('create-service-modal')" />
        </div>
    @endcan
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @foreach ($services as $service)
            <x-ts-card class="flex justify-between items-center gap-4">
                <div>
                    <a href="{{ route('services.show', $service->alias) }}">
                        <h3 class="font-semibold">{{ $service->name }}</h3>
                    </a>
                    <p class="text-sm text-gray-600">{{ $service->description }}</p>
                </div>
                <div>
                    <x-ts-button icon="question-mark-circle" :href="route('services.questions', $service->alias)" flat />
                    <x-ts-button icon="calendar" :href="route('services.events', $service->alias)" flat />
                    @can('edit', $service)
                        <x-ts-button icon="pencil" flat />
                    @endcan
                </div>
            </x-ts-card>
        @endforeach
    </div>
    @can('create', App\Models\Service::class)
        <livewire:services.create @saved="$refresh" />
    @endcan
</div>
