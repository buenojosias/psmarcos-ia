<x-ts-card header="Grupos, movimentos, pastorais e comunidade">
    @if ($pastorals->isEmpty() && $communities->isEmpty())
        <p class="text-sm text-gray-500">Nada associado.</p>
    @else
        <ul class="divide-y">
            @foreach ($communities as $community)
                <li class="py-2">
                    <p class="font-semibold text-gray-700 dark:text-gray-300">
                        <a href="{{ route('communities.show', $community) }}" class="hover:underline">
                            {{ $community->name }}
                            <small>({{ $community->pivot->is_leader ? 'Coordenador' : 'Membro' }})</small>
                        </a>
                    </p>
                </li>
            @endforeach
            @foreach ($pastorals as $pastoral)
                <li class="py-2">
                    <p class="font-semibold text-gray-700 dark:text-gray-300">
                        <a href="{{ route('pastorals.show', $pastoral) }}" class="hover:underline">
                            {{ $pastoral->name }}
                            <small>({{ $pastoral->pivot->is_leader ? 'Coordenador' : 'Membro' }})</small>
                        </a>
                    </p>
                    @if ($pastoral->community)
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pastoral->community->name }}</p>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
</x-ts-card>
