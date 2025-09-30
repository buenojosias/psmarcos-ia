<div class="space-y-4">
    <h2>Perguntas e respostas</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <livewire:questions.questions-list resource="event" :model="$this->event" />
        </div>
        <div>
            <livewire:questions.create resource="event" :model="$this->event" />
        </div>
    </div>
</div>
