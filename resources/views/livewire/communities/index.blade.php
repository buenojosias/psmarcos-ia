<div>
    <livewire:communities.create @saved="$refresh" />
    <div class="flex flex-col gap-y-2 mt-6">
        @foreach ($this->communities as $community)
            <a href="{{ route('communities.show', $community) }}">
                <x-ts-card>
                    {{ $community->name }}
                </x-ts-card>
            </a>
        @endforeach
    </div>
</div>
