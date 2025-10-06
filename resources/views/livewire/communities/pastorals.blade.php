<div class="space-y-4">
    <h2>{{ $community->name }}</h2>
    <livewire:pastorals.create :community_id="$community->id" />
    <x-ts-table :headers="$headers" :rows="$rows">
        @interact('column_pastoral_name', $row)
            <a href="{{ route('pastorals.show', $row) }}">{{ $row->name }}</a>
        @endinteract
        @interact('column_action', $row)
            <div class="space-x-2">
                <x-ts-link :href="route('pastorals.questions', $row)" icon="question-mark-circle" title="Perguntas" />
                <x-ts-link :href="route('pastorals.events', $row)" icon="calendar" title="Eventos" />
            </div>
        @endinteract
    </x-ts-table>
</div>
