<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechQuest RH — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen">

    {{-- ===== HEADER / NAVIGATION ===== --}}
    <nav class="bg-blue-700 text-white px-6 py-4 flex justify-between items-center">

        {{-- Logo --}}
        <a href="/dashboard" class="text-2xl font-bold">
            🎮 TechQuest RH
        </a>

        {{-- Menu --}}
        <div class="flex items-center gap-6 text-lg">
            <a href="/dashboard" class="hover:underline">Accueil</a>
            <a href="/historique" class="hover:underline">Mon historique</a>

            {{-- XP et Niveau de l'employé --}}
            <span class="bg-blue-500 px-4 py-2 rounded-full text-base">
                ⭐ {{ Auth::user()->xp_total }} XP
            </span>
            <span class="bg-green-500 px-4 py-2 rounded-full text-base">
                🏆 {{ ucfirst(Auth::user()->niveau) }}
            </span>

            {{-- Déconnexion --}}
            <form method="POST" action="/logout">
                @csrf
                <button class="bg-red-500 px-4 py-2 rounded-lg hover:bg-red-600 text-base">
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    {{-- ===== MESSAGES DE SUCCÈS / ERREUR ===== --}}
    <div class="max-w-5xl mx-auto mt-4 px-4">

        {{-- Message succès --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-800
                        px-6 py-4 rounded-lg text-lg mb-4">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Message erreur --}}
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-800
                        px-6 py-4 rounded-lg text-lg mb-4">
                ⚠️ {{ session('error') }}
            </div>
        @endif

    </div>

    {{-- ===== CONTENU PRINCIPAL ===== --}}
    <main class="max-w-5xl mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer class="text-center text-gray-500 py-6 text-base mt-8">
        © 2026 TechQuest RH — Votre progression, à votre rythme 🌟
    </footer>

</body>
</html>