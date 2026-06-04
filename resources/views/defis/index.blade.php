@extends('layouts.app')

@section('title', 'Défis — ' . $parcours->titre)

@section('content')

    {{-- Titre du parcours --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            📚 {{ $parcours->titre }}
        </h1>
        <p class="text-gray-600 text-lg mt-2">
            {{ $parcours->description }}
        </p>
    </div>

    {{-- Liste des défis --}}
    <div class="grid gap-6">

        @foreach($defis as $defi)

            <div class="bg-white rounded-xl shadow p-6
                        {{ $defi->verrouille ? 'opacity-50' : '' }}">

                <div class="flex justify-between items-center">

                    {{-- Info défi --}}
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">
                            {{ $defi->titre }}
                        </h2>

                        {{-- Niveau --}}
                        <span class="inline-block mt-2 px-3 py-1 rounded-full text-base
                            {{ $defi->niveau === 'debutant' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $defi->niveau === 'intermediaire' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $defi->niveau === 'expert' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst($defi->niveau) }}
                        </span>

                        {{-- XP --}}
                        <span class="inline-block mt-2 ml-2 px-3 py-1
                                    bg-blue-100 text-blue-700 rounded-full text-base">
                            ⭐ {{ $defi->xp_recompense }} XP
                        </span>

                        {{-- Type --}}
                        <span class="inline-block mt-2 ml-2 px-3 py-1
                                    bg-purple-100 text-purple-700 rounded-full text-base">
                            {{ $defi->type === 'qcm' ? '📝 QCM' : '✅ Vrai / Faux' }}
                        </span>
                    </div>

                    {{-- Bouton --}}
                    @if($defi->verrouille)
                        <div class="text-center">
                            <span class="text-4xl">🔒</span>
                            <p class="text-gray-500 text-base mt-1">
                                Niveau insuffisant
                            </p>
                        </div>
                    @else
                        <a href="{{ route('defis.show', $defi->id) }}"
                           class="bg-blue-600 text-white px-8 py-4 rounded-xl
                                  text-lg font-semibold hover:bg-blue-700
                                  transition-colors">
                            Commencer →
                        </a>
                    @endif

                </div>
            </div>

        @endforeach

    </div>

@endsection