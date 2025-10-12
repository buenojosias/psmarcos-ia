<div class="space-y-4">
    <h2>{{ $this->community->name }}</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <livewire:questions.questions-list resource="community" :model="$this->community" />
        </div>
        <div>
            <livewire:questions.create resource="community" :model="$this->community" />
        </div>
    </div>
</div>
