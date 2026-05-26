<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
        {{ __('Mon Catalogue de Formations') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-indigo-50 p-6 rounded-lg mb-8 border-l-4 border-indigo-500">
                <p class="text-xl text-indigo-900">
                    Bonjour Mr/Mme {{ Auth::user()->name }}, choisissez un thème pour commencer votre aventure et gagner de l'XP !
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($parcours as $item)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border border-gray-200 hover:border-indigo-300 transition">
                        <div class="flex justify-between items-start mb-4">
                            <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-bold uppercase">
                                {{ $item->outil }}
                            </span>
                        </div>
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $item->titre }}</h3>
                        <p class="text-gray-600 text-lg mb-6 line-clamp-3">
                            {{ $item->description }}
                        </p>

                        <div class="flex items-center justify-between mt-auto">
                            <span class="text-sm font-medium text-gray-500">
                                {{ $item->nb_defis_total }} Défis à relever
                            </span>
                            
                            <form action="{{ route('parcours.choisir', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-lg text-white hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 transition ease-in-out duration-150">
                                    Commencer
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>