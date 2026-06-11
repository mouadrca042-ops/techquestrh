<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Catalogue de Formations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-50 p-6 rounded-lg mb-8 border-l-4 border-indigo-500">
                <p class="text-xl text-indigo-900">
                    Bonjour {{ Auth::user()->name }}, retrouvez ici toutes les formations. Lancez-en une nouvelle ou reprenez celles que vous avez commencées !
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($parcours as $item)
                    @php $estCommencee = in_array($item->id, $dejaCommenceesIds); @endphp

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border transition flex flex-col
                        {{ $estCommencee ? 'border-green-300' : 'border-gray-200 hover:border-indigo-300' }}">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <x-formation-logo :outil="$item->outil" size="md" />
                                <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-bold uppercase">
                                    {{ $item->outil }}
                                </span>
                            </div>
                            @if($estCommencee)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">
                                    En cours
                                </span>
                            @endif
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->titre }}</h3>
                        <p class="text-gray-600 text-lg mb-5 line-clamp-3">
                            {{ $item->description }}
                        </p>

                        {{-- Modules par niveau de difficulté (conforme à la base de données) --}}
                        <div class="flex flex-wrap gap-2 mb-6">
                            @if($item->defis_debutant)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                                    {{ $item->defis_debutant }} Débutant
                                </span>
                            @endif
                            @if($item->defis_intermediaire)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700">
                                    {{ $item->defis_intermediaire }} Intermédiaire
                                </span>
                            @endif
                            @if($item->defis_expert)
                                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">
                                    {{ $item->defis_expert }} Expert
                                </span>
                            @endif
                        </div>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm font-medium text-gray-500">
                                {{ $item->nb_defis_total }} modules à relever
                            </span>

                            @if($estCommencee)
                                {{-- Formation déjà commencée → Continuer --}}
                                <a href="{{ route('parcours.show', $item) }}"
                                   class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-bold text-lg text-white hover:bg-green-700 transition ease-in-out duration-150">
                                    Continuer
                                </a>
                            @else
                                {{-- Nouvelle formation → Commencer --}}
                                <form action="{{ route('parcours.choisir', $item) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-lg text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                        Commencer
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
