<div>
    <x-ts-card header="Usuários vinculados" minimize="mount">
        <div class="space-y-3">
            @forelse($this->users ?? [] as $user)
                <div
                    class="p-4 border dark:border-none rounded-lg flex items-center justify-between dark:bg-gray-800 shadow-sm">
                    <div>
                        <p class="font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $user->pivot->is_leader ? 'Coordenador(a)' : 'Membro' }}
                        </p>
                    </div>
                    <div>
                        <x-ts-dropdown icon="ellipsis-vertical">
                            @can('edit', $model)
                                <x-ts-dropdown.items :text="$user->pivot->is_leader
                                    ? 'Remover de coordenador(a)'
                                    : 'Tornar coordenador(a)'" wire:click="toggleLeader({{ $user->id }})" />
                                <x-ts-dropdown.items text="Desvincular" wire:click="detachUser({{ $user->id }})" />
                            @endcan
                            <x-ts-dropdown.items text="Ver perfil" :href="route('users.show', $user)" separator />
                        </x-ts-dropdown>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">Nenhum usuário vinculado.</p>
            @endforelse
        </div>
        @can('edit', $model)
            <x-slot:footer class="flex gap-2">
                <x-ts-button text="Vincular usuário" x-on:click="$modalOpen('attach-user-modal')" class="flex-1" />
                <x-ts-button text="Cadastrar" x-on:click="$modalOpen('create-user-modal')" color="secondary" class="flex-1" />
            </x-slot>
        @endcan
    </x-ts-card>
    @can('edit', $model)
        <livewire:user-pivot.attach-user :resource="$resource" :model="$model" @attached="$refresh" />
        <livewire:user-pivot.create-user :model="$this->model" @saved="$refresh" />
    @endcan
</div>
