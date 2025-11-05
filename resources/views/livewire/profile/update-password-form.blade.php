<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\rules;
use function Livewire\Volt\state;

state([
    'current_password' => '',
    'password' => '',
    'password_confirmation' => '',
]);

rules([
    'current_password' => ['required', 'string', 'current_password'],
    'password' => ['required', 'string', Password::defaults(), 'confirmed'],
]);

$updatePassword = function () {
    try {
        $validated = $this->validate();
    } catch (ValidationException $e) {
        $this->reset('current_password', 'password', 'password_confirmation');

        throw $e;
    }

    Auth::user()->update([
        'password' => Hash::make($validated['password']),
    ]);

    $this->reset('current_password', 'password', 'password_confirmation');

    $this->dispatch('password-updated');
};

?>

<x-ts-card header="Alterar senha" minimize="mount">
    <p class="text-sm text-gray-600">
        Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.
    </p>
    <x-ts-errors />
    <form wire:submit="updatePassword" id="update-password-form" class="mt-4 space-y-4">
        <x-ts-input wire:model="current_password" type="password" label="Senha atual" />
        <x-ts-input wire:model="password" type="password" label="Nova senha" />
        <x-ts-input wire:model="password_confirmation" type="password" label="Confirme a nova senha" />
    </form>
    <x-slot:footer>
        <x-ts-button type="submit" form="update-password-form">{{ __('Save') }}</x-ts-button>

        <x-action-message class="me-3" on="password-updated">
            {{ __('Saved.') }}
        </x-action-message>
    </x-slot>
</x-ts-card>
