<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $parcours->titre }}
            </h2>
            <a href="{{ route('parcours.index') }}" class="text-blue-600 hover:underline font-semibold">
                &larr; Retour au catalogue
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if(session('success'))
                <div id="msg-success" class="bg-green-50 border-2 border-green-300 text-green-800 rounded-2xl px-6 py-5 mb-6 text-lg font-semibold transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('explication'))
                <div id="msg-explication" class="bg-blue-50 border-2 border-blue-200 text-blue-800 rounded-2xl px-6 py-5 mb-6 text-base transition-opacity duration-500">
                    💡 <span class="font-bold">Explication :</span> {{ session('explication') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl p-8 mb-8 border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-gray-700">Votre avancée dans ce parcours</h3>
                    <span class="text-2xl font-black text-blue-600">{{ $progression }}%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-6 border border-gray-200">
                    <div class="bg-blue-500 h-full rounded-full transition-all duration-1000 shadow-inner" 
                         style="width: {{ $progression }}%"></div>
                </div>
                <p class="mt-4 text-gray-500 italic">
                    Complétez tous les défis pour obtenir votre badge de certification.
                </p>
            </div>

            <div class="space-y-6">
                <h3 class="text-2xl font-bold text-gray-800 ml-2">Les étapes à franchir</h3>
                
                @forelse($defis as $index => $defi)
                    <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-6 flex items-center justify-between border-2 {{ $defi->est_complete ? 'border-green-100 bg-green-50' : 'border-transparent' }}">
                        
                        <div class="flex items-center space-x-6">
                            <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-bold text-xl {{ $defi->est_complete ? 'bg-green-500 text-white' : 'bg-blue-100 text-blue-600' }}">
                                {{ $index + 1 }}
                            </div>
                            
                            <div>
                                <h4 class="text-xl font-bold text-gray-900">{{ $defi->titre }}</h4>
                                <p class="text-gray-600">{{ $defi->description }}</p>
                                <div class="mt-2 flex items-center space-x-4">
                                    <span class="text-xs font-bold uppercase px-2 py-1 bg-gray-200 rounded text-gray-600">
                                        Niveau {{ $defi->niveau }}
                                    </span>
                                    <span class="text-xs font-bold text-blue-500">
                                        + {{ $defi->xp_recompense ?? 50 }} XP
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="ml-4">
                            @if($defi->est_complete)
                                <div class="flex items-center text-green-600 font-bold">
                                    <svg class="w-8 h-8 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Réussi
                                </div>
                            @else
                                <a href="{{ route('defis.show', $defi->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold text-lg shadow-lg transition-transform active:scale-95 inline-block text-center">
                                    Lancer
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <p class="text-gray-500">Aucun défi n'est encore disponible pour ce parcours.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            ['msg-success', 'msg-explication'].forEach(function(id) {
                var el = document.getElementById(id);
                if (el) {
                    el.style.opacity = '0';
                    setTimeout(function() { el.style.display = 'none'; }, 500);
                }
            });
        }, 3000);
    </script>

</x-app-layout>