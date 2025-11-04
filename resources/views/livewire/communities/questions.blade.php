<div class="space-y-4">
    <h2 class="flex items-center gap-2">
        <a href="{{ route('communities.show', $this->community) }}">
            <x-ts-icon name="arrow-left" class="w-4 h-4 text-gray-700 dark:text-gray-300" />
        </a>
        {{ $this->community->name }}
    </h2>
    @can('manage', $this->community)
        <div class="grid grid-cols-1 lg:grid-cols-2 sm:grid-reverse gap-4">
            <div>
                <livewire:questions.create resource="community" :model="$this->community" />
            </div>
            <div>
                <livewire:questions.questions-list resource="community" :model="$this->community" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="community" :model="$this->community" />
    @endcan
</div>
