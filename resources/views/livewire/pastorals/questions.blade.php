<div class="space-y-4">
    <h2>{{ $this->pastoral->name }}</h2>
    @can('manage', $this->pastoral)
        <div class="grid grid-cols-1 lg:grid-cols-2 sm:grid-reverse gap-4">
            <div>
                <livewire:questions.create resource="pastoral" :model="$this->pastoral" />
            </div>
            <div>
                <livewire:questions.questions-list resource="pastoral" :model="$this->pastoral" />
            </div>
        </div>
    @else
        <livewire:questions.guest-list resource="pastoral" :model="$this->pastoral" />
    @endcan
</div>
