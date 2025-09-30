<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="tallstackui_darkTheme()"
    x-bind:class="{ 'dark bg-gray-700': darkTheme, 'bg-gray-100': !darkTheme }">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Treinamento de IA - PSMarcos') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <tallstackui:script />
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <x-ts-toast />
    <x-ts-layout>
        <x-slot:header>
            <x-ts-layout.header>
                <x-slot:left>
                    <h3 class="font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h3>
                </x-slot:left>
                <x-slot:right>
                    @livewire('layout.dropdown')
                </x-slot:right>
            </x-ts-layout.header>
        </x-slot:header>

        <x-slot:menu>
            <x-ts-side-bar>
                <x-slot:brand>
                    <div class="p-2 flex space-x-4 items-center">
                        <img src="{{ asset('img/logo.png') }}" class="h-10" />
                        <div class="">
                            <p class="font-semibold text-gray-900 dark:text-gray-200">Paróquia São Marcos</p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Agente de IA</p>
                        </div>
                    </div>
                </x-slot:brand>
                <x-ts-side-bar.item text="Home" icon="home" :route="route('dashboard')" :current="request()->routeIs('dashboard')" />
                <x-ts-side-bar.item text="Comunidades" icon="building-library" :route="route('communities.index')" :current="request()->routeIs('communities.*')" />
                <x-ts-side-bar.item text="Grupos, movimentos e pastorais" icon="user-group" :route="route('pastorals.index')"
                    :current="request()->routeIs('pastorals.*')" />
                <x-ts-side-bar.item text="Eventos" icon="calendar" :route="route('events.index')" :current="request()->routeIs('events.*')" />
                <x-ts-side-bar.item text="Usuários" icon="user" :route="route('users.index')" :current="request()->routeIs('users.*')" />
            </x-ts-side-bar>
        </x-slot:menu>

        {{ $slot }}
    </x-ts-layout>

    @livewireScripts
</body>
