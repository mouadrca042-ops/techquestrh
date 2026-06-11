<x-app-layout>
    <div class="py-10">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- En-tête --}}
            <div class="text-center">
                <div class="text-5xl mb-3">🎯</div>
                <h1 class="text-2xl font-black text-gray-900">Test de positionnement</h1>
                <p class="text-gray-500 mt-2">
                    <span class="font-semibold text-gray-700">{{ $parcours->titre }}</span>
                    — 3 questions pour situer votre niveau de départ.
                </p>
                <p class="text-sm text-gray-400 mt-1">
                    Aucune pression : ce test ne compte pas dans votre score, il oriente juste votre parcours.
                </p>
            </div>

            {{-- Formulaire --}}
            <form action="{{ route('positionnement.check', $parcours) }}" method="POST" class="space-y-5">
                @csrf

                @foreach($questions as $index => $q)
                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">

                        <div class="flex items-center gap-2 mb-4">
                            <span class="text-xs font-bold px-2 py-0.5 rounded-full
                                {{ $q['niveau'] === 'debutant'      ? 'bg-green-100 text-green-700'  : '' }}
                                {{ $q['niveau'] === 'intermediaire' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $q['niveau'] === 'expert'        ? 'bg-red-100 text-red-700'      : '' }}">
                                {{ ucfirst($q['niveau']) }}
                            </span>
                            <span class="text-sm font-semibold text-gray-700">
                                Question {{ $index + 1 }}/{{ count($questions) }}
                            </span>
                        </div>

                        <p class="font-semibold text-gray-800 mb-4">{{ $q['question'] }}</p>

                        @if($q['type'] === 'qcm')
                            <div class="space-y-3">
                                @foreach($q['options'] as $i => $option)
                                    <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl
                                                  cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all">
                                        <input type="radio"
                                               name="reponses[{{ $q['id'] }}]"
                                               value="{{ $i }}"
                                               class="w-4 h-4 text-blue-600"
                                               required>
                                        <span class="ml-3 text-gray-700">{{ $option }}</span>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="flex gap-4">
                                <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl
                                              cursor-pointer hover:bg-green-50 hover:border-green-400 transition-all font-semibold text-gray-700">
                                    <input type="radio" name="reponses[{{ $q['id'] }}]" value="Vrai" class="mr-2" required> Vrai
                                </label>
                                <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl
                                              cursor-pointer hover:bg-red-50 hover:border-red-400 transition-all font-semibold text-gray-700">
                                    <input type="radio" name="reponses[{{ $q['id'] }}]" value="Faux" class="mr-2"> Faux
                                </label>
                            </div>
                        @endif
                    </div>
                @endforeach

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl
                               font-bold text-xl shadow-lg transition-all active:scale-95">
                    Voir mon niveau de départ →
                </button>
            </form>

            <p class="text-center text-sm text-gray-400">
                <a href="{{ route('parcours.show', $parcours) }}" class="hover:underline">
                    Passer le test et commencer directement
                </a>
            </p>

        </div>
    </div>
</x-app-layout>
