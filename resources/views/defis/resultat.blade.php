@extends('layouts.app')

@section('title', 'Résultat')

@section('content')

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto text-center">

        {{-- Résultat correct ou incorrect --}}
        @if($correct)
            <div class="text-7xl mb-4">🎉</div>
            <h1 class="text-3xl font-bold text-green-600 mb-2">
                Excellente réponse !
            </h1>
            <p class="text-xl text-gray-700 mb-6">
                Vous avez gagné
                <span class="font-bold text-blue-600">
                    +{{ $defi->xp_recompense }} XP
                </span>
            </p>
        @else
            <div class="text-7xl mb-4">💪</div>
            <h1 class="text-3xl font-bold text-orange-500 mb-2">
                Bonne tentative !
            </h1>
            <p class="text-xl text-gray-700 mb-6">
                Ce n'est pas grave, vous pouvez réessayer !
            </p>
        @endif

        {{-- Explication bienveillante CDC F14 --}}
        <div class="bg-blue-50 rounded-xl p-6 mb-8 text-left">
            <p class="text-lg text-gray-700 leading-relaxed">
                💡 <strong>Explication :</strong> {{ $explication }}
            </p>
        </div>

        {{-- Nombre de tentatives CDC F13 --}}
        <p class="text-gray-500 text-base mb-8">
            Tentatives sur ce défi : {{ $progression->tentatives }}
        </p>

        {{-- Boutons --}}
        <div class="grid grid-cols-2 gap-4">

            {{-- Réessayer CDC F13 --}}
            <a href="{{ route('defis.show', $defi->id) }}"
               class="bg-orange-500 text-white py-4 rounded-xl
                      text-lg font-semibold hover:bg-orange-600
                      transition-colors">
                🔄 Réessayer
            </a>

            {{-- Retour aux défis --}}
            <a href="{{ route('defis.index', $defi->parcours_id) }}"
               class="bg-blue-600 text-white py-4 rounded-xl
                      text-lg font-semibold hover:bg-blue-700
                      transition-colors">
                📚 Autres défis →
            </a>

        </div>

    </div>

@endsection