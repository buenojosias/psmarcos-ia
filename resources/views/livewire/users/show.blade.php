<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="space-y-4">
        <x-ts-card header="Informações" class="detail">
            <x-detail label="Nome" :value="$user->name" />
            <x-detail label="E-mail" :value="$user->email" />
            <x-slot:footer>
                <livewire:users.edit :user="$user" @saved="$refresh" />
                {{-- <x-ts-button text="Excluir" icon="trash" color="red" flat /> --}}
            </x-slot:footer>
        </x-ts-card>
        <x-ts-card header="Funções" class="grid grid-cols-1 sm:grid-cols-2 gap-2">
            @foreach ($roles as $role)
                <x-ts-badge :text="$role->getLabel()" :color="in_array($role->value, $user->roles ?? []) ? 'green' : 'secondary'" :icon="in_array($role->value, $user->roles ?? []) ? 'check' : 'x-mark'" outline md position="left" />
            @endforeach
            <x-slot:footer>
                <livewire:users.manage-roles :user="$user" @saved="$refresh" />
            </x-slot>
        </x-ts-card>
    </div>
    <div>
        <x-ts-card header="Grupos, movimentos e pastorais">
            @if ($user->pastorals->isEmpty())
                <p class="text-sm text-gray-500">Nenhum grupo, movimento ou pastoral associado.</p>
            @else
                <ul class="space-y-4">
                    @foreach ($user->pastorals as $pastoral)
                        <li>
                            <p class="font-semibold text-gray-700 dark:text-gray-300">
                                <a href="{{ route('pastorals.show', $pastoral) }}" class="hover:underline">
                                    {{ $pastoral->name }}
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
    </div>
</div>
