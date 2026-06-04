<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TechQuest RH') }}@hasSection('title') — @yield('title')@endif</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            {{-- Navigation unifiée (Dashboard, Formations, Mes Badges, profil…) --}}
            @include('layouts.navigation')

            {{-- En-tête de page (slot Breeze, optionnel) --}}
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            {{-- Contenu : supporte les deux conventions --}}
            <main>
                @hasSection('content')
                    {{-- vues en @extends('layouts.app') + @section('content') (ex. /historique) --}}
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                        @yield('content')
                    </div>
                @else
                    {{-- vues Breeze <x-app-layout> … </x-app-layout> (dashboard, formations, défis) --}}
                    {{ $slot ?? '' }}
                @endif
            </main>
        </div>
    </body>
</html>
