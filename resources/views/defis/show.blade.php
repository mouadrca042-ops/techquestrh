@extends('layouts.app')

@section('title', $defi->titre)

@section('content')

@php
    $contenu = is_array($defi->contenu_json) ? $defi->contenu_json : json_decode($defi->contenu_json, true);
@endphp

    <div class="bg-white rounded-xl shadow-lg p-8 max-w-2xl mx-auto">

        {{-- Titre --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-2">
            {{ $defi->titre }}
        </h1>

        {{-- Infos --}}
        <div class="flex gap-3 mb-8">
            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-base">
                ⭐ {{ $defi->xp_recompense }} XP à gagner
            </span>
            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-base">
                {{ ucfirst($defi->niveau) }}
            </span>
        </div>

        {{-- Question --}}
        <div class="bg-blue-50 rounded-xl p-6 mb-8">
            <p class="text-xl text-gray-800 font-medium leading-relaxed">
                {{ $contenu['question'] ?? 'Question non disponible' }}
            </p>
        </div>

        {{-- Formulaire de réponse --}}
        <form method="POST" action="{{ route('defis.valider', $defi->id) }}">
            @csrf

            {{-- CAS 1 : QCM --}}
            @if($defi->type === 'qcm')
                <div class="grid gap-4 mb-8">
                    @foreach($contenu['options'] ?? [] as $index => $option)
                        <label class="flex items-center gap-4 bg-gray-50
                                      border-2 border-gray-200 rounded-xl
                                      p-5 cursor-pointer hover:border-blue-400
                                      hover:bg-blue-50 transition-colors text-lg">
                            <input type="radio"
                                   name="reponse"
                                   value="{{ $option }}"
                                   class="w-6 h-6 accent-blue-600"
                                   required>
                            {{ $option }}
                        </label>
                    @endforeach
                </div>

            {{-- CAS 2 : Vrai/Faux --}}
            @elseif($defi->type === 'vrai_faux')
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <label class="flex items-center justify-center gap-3
                                  bg-green-50 border-2 border-green-200
                                  rounded-xl p-6 cursor-pointer
                                  hover:border-green-500 hover:bg-green-100
                                  transition-colors text-xl font-semibold">
                        <input type="radio"
                               name="reponse"
                               value="1"
                               class="w-6 h-6 accent-green-600"
                               required>
                        ✅ Vrai
                    </label>

                    <label class="flex items-center justify-center gap-3
                                  bg-red-50 border-2 border-red-200
                                  rounded-xl p-6 cursor-pointer
                                  hover:border-red-500 hover:bg-red-100
                                  transition-colors text-xl font-semibold">
                        <input type="radio"
                               name="reponse"
                               value="0"
                               class="w-6 h-6 accent-red-600"
                               required>
                        ❌ Faux
                    </label>
                </div>
            @endif

            {{-- Bouton valider --}}
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-5
                           rounded-xl text-xl font-bold
                           hover:bg-blue-700 transition-colors">
                Valider ma réponse →
            </button>

        </form>

        {{-- Tentatives précédentes --}}
        @if(isset($progression) && $progression->tentatives > 0)
            <p class="text-center text-gray-500 text-base mt-4">
                💡 Tentatives précédentes : {{ $progression->tentatives }}
                — Continuez, vous pouvez le faire !
            </p>
        @endif

    </div>

@endsection