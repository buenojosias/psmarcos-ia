<div class="space-y-4">
    <h2>Perguntas e respostas</h2>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div>
            <livewire:questions.questions-list :model="$this->pastoral" />
        </div>
        <div>
            <livewire:questions.create resource="grupo" :model="$this->pastoral" />
        </div>
    </div>
</div>
