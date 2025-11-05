<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
    <div class="space-y-4">
        <x-ts-card header="Informações" class="detail">
            <x-detail label="Nome" :value="$user->name" />
            @can('edit', $user)
                <x-detail label="E-mail" :value="$user->email" />
            @endcan
            <x-detail label="Cadastrado por" :value="$user->parent?->name ?? 'Sistema'" />
            <x-detail label="Data do cadastro" :value="$user->created_at->format('d/m/Y H:i')" />
            @can('edit', $user)
                <x-slot:footer>
                    <livewire:users.edit :user="$user" @saved="$refresh" />
                </x-slot:footer>
            @endcan
        </x-ts-card>
        @can('any', App\Models\User::class)
            <x-ts-card header="Funções" class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @foreach ($roles as $role)
                    <x-ts-badge :text="$role->getLabel()" :color="in_array($role->value, $user->roles ?? []) ? 'green' : 'secondary'" :icon="in_array($role->value, $user->roles ?? []) ? 'check' : 'x-mark'" outline md position="left" />
                @endforeach
                @can('editAdmin', $user)
                    <x-slot:footer>
                        <livewire:users.manage-roles :user="$user" @saved="$refresh" />
                    </x-slot>
                @endcan
            </x-ts-card>
        @endcan
    </div>
    <div>
        <livewire:users.pastorals :user="$user" />
    </div>
</div>
