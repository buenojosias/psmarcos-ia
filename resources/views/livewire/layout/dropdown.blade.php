<?php

use App\Livewire\Actions\Logout;

use Livewire\Volt\Component;

new class extends Component {
    public function goToProfile()
    {
        $this->redirect(route('profile'), navigate: false);
    }

    public function logout(Logout $logout)
    {
        $logout();

        $this->redirect('/', navigate: false);
    }
};


?>

<x-ts-dropdown>
    <x-slot:action>
        <x-ts-button.circle :text="auth()->user()->name[0]" x-on:click="show = !show" md />
    </x-slot:action>
    <x-slot:header>
        <p class="px-2 text-sm text-gray-700 dark:text-gray-100 font-semibold">{{ auth()->user()->name }}</p>
    </x-slot:header>
    <x-ts-dropdown.items text="Perfil" wire:click="goToProfile" />
    <x-ts-dropdown.items text="Sair" wire:click="logout" />
    <x-ts-dropdown.items separator>
        <x-ts-toggle label="Modo escuro" x-model="darkTheme" />
    </x-ts-dropdown.items>
</x-ts-dropdown>
