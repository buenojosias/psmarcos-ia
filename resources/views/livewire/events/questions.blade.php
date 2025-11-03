<div class="space-y-4">
    <h2>{{ $this->event->name }}</h2>
    @can('manage', $this->event)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div>
                <livewire:questions.create resource="event" :model="$this->event" />
            </div>
            <div>
                <livewire:questions.questions-list resource="event" :model="$this->event" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="event" :model="$this->event" />
    @endcan
</div>
