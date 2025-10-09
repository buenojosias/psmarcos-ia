<div>
    <x-ts-card header="Usuários vinculados" minimize="mount">
        <div class="space-y-3">
            @forelse($this->users ?? [] as $user)
                <div class="p-4 border dark:border-none rounded-lg flex items-center justify-between dark:bg-gray-800 shadow-sm">
                    <div>
                        <p class="font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <p class="text-sm text-gray-600">
                            {{ $user->pivot->is_leader ? 'Coordenador(a)' : 'Membro' }}
                        </p>
                    </div>
                    <div>
                        <x-ts-dropdown icon="ellipsis-vertical">
                            <x-ts-dropdown.items :text="$user->pivot->is_leader ? 'Remover de coordenador(a)' : 'Tornar coordenador(a)'" wire:click="toggleLeader({{ $user->id }})" />
                            <x-ts-dropdown.items text="Desvincular" wire:click="detachUser({{ $user->id }})" />
                            <x-ts-dropdown.items text="Ver perfil" separator />
                        </x-ts-dropdown>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-600">Nenhum usuário vinculado a esta pastoral.</
            @endforelse
        </div>
        <x-slot:footer class="flex gap-2">
            <x-ts-button text="Vincular usuário" x-on:click="$modalOpen('attach-user-modal')" class="flex-1" />
            <x-ts-button text="Cadastrar" x-on:click="$modalOpen('create-user-modal')" class="flex-1" />
        </x-slot>
    </x-ts-card>
    <livewire:pastorals.attach-user :pastoral="$this->pastoral" @attached="$refresh" />
    <livewire:pastorals.create-user :pastoral="$this->pastoral" @saved="$refresh" />
</div>
