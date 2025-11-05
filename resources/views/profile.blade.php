<x-app-layout>
    <x-slot name="title">
        Perfil
    </x-slot>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="space-y-4">
            <livewire:profile.update-profile-information-form />
            <livewire:profile.update-password-form />
            <livewire:profile.delete-user-form />
        </div>
        <div>
            <livewire:users.pastorals :user="auth()->user()" />
        </div>
    </div>
</x-app-layout>
