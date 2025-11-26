<div class="space-y-4">
    <h2 class="flex items-center gap-2">
        <a href="{{ route('services.show', $this->service->alias) }}">
            <x-ts-icon name="arrow-left" class="w-4 h-4 text-gray-700 dark:text-gray-300" />
        </a>
        {{ $this->service->name }}
    </h2>
    @anyrole(['admin', 'pascom', 'secretary'])
        <div class="grid grid-cols-1 lg:grid-cols-2 sm:grid-reverse gap-4">
            <div>
                <livewire:questions.create resource="service" :model="$this->service" />
            </div>
            <div>
                <livewire:questions.questions-list resource="service" :model="$this->service" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="service" :model="$this->service" />
    @endanyrole
</div>
