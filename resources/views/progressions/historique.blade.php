@extends('layouts.app')

@section('title', 'Mon Historique')

@section('content')

    <h1 class="text-3xl font-bold text-gray-800 mb-8">
        📋 Mon Historique de défis
    </h1>

    @if($progressions->isEmpty())
        <div class="bg-white rounded-xl shadow p-8 text-center">
            <p class="text-xl text-gray-500">
                Vous n'avez pas encore complété de défi.
                <br>Commencez dès maintenant ! 🚀
            </p>
        </div>
    @else

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full text-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-6 py-4 text-left">Défi</th>
                        <th class="px-6 py-4 text-left">Parcours</th>
                        <th class="px-6 py-4 text-center">Score</th>
                        <th class="px-6 py-4 text-center">Tentatives</th>
                        <th class="px-6 py-4 text-left">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($progressions as $progression)
                        <tr class="border-b border-gray-100
                                   hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                {{ $progression->defi->titre }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $progression->defi->parcours->titre }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($progression->score == 100)
                                    <span class="text-green-600 font-bold">
                                        ✅ {{ $progression->score }}%
                                    </span>
                                @else
                                    <span class="text-orange-500 font-bold">
                                        {{ $progression->score }}%
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $progression->tentatives }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $progression->completed_at
                                   ? $progression->completed_at->format('d/m/Y H:i')
                                   : '—' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif

@endsection