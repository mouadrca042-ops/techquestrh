<x-app-layout>
    @php
        $resultats = session('resultats_examen');     // null ou array indexé par id
        $score     = session('score_examen');          // null ou int
        $reussi    = session('examen_reussi');          // null ou bool
    @endphp

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- En-tête --}}
            <div class="flex items-center gap-4">
                <x-formation-logo :outil="$parcours->outil" size="lg" />
                <div>
                    <a href="{{ route('parcours.show', $parcours) }}" class="text-sm text-blue-600 hover:underline">← Retour à la formation</a>
                    <h1 class="text-2xl font-black text-gray-900">Test final — {{ $parcours->titre }}</h1>
                    <p class="text-gray-500">Réussis cet examen (≥ 70 %) pour débloquer le badge secret 🏅</p>
                </div>
            </div>

            @if($score !== null)
                {{-- ───────── RÉSULTAT ───────── --}}
                @if($reussi)
                    <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-8 text-center">
                        <div class="text-5xl font-black text-green-600 mb-1">{{ $score }}%</div>
                        <div class="text-2xl font-black text-green-800">Examen réussi — bravo ! 🎉</div>
                        @if(session('badge_secret'))
                            <div class="mt-5 flex flex-col items-center">
                                <x-badge-icon :type="session('badge_secret')['type']" :unlocked="true" size="lg" />
                                <p class="mt-2 font-bold text-purple-700">🏅 Badge secret débloqué : {{ session('badge_secret')['titre'] }}</p>
                                <a href="{{ route('badges.index') }}" class="mt-2 text-sm font-semibold text-purple-700 underline">Voir mes badges</a>
                            </div>
                        @else
                            <p class="text-green-700 text-sm mt-1">Tu avais déjà décroché le badge secret 😉</p>
                        @endif
                    </div>
                @else
                    <div class="bg-orange-50 border-2 border-orange-300 rounded-2xl p-8 text-center">
                        <div class="text-5xl font-black text-orange-500 mb-1">{{ $score }}%</div>
                        <div class="text-xl font-black text-orange-800">Pas encore réussi — il faut 70 %.</div>
                        <p class="text-orange-700 text-sm mt-1">Relis tes modules et retente le test, tu vas y arriver !</p>
                    </div>
                @endif

                {{-- Correction --}}
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-gray-700">
                        Correction — {{ count(array_filter($resultats, fn($r) => $r['correct'])) }}/{{ count($questions) }} bonnes réponses
                    </h2>
                    @foreach($questions as $index => $q)
                        @php $r = $resultats[$q['id']]; @endphp
                        <div class="bg-white border-2 rounded-2xl p-5 {{ $r['correct'] ? 'border-green-300' : 'border-red-300' }}">
                            <div class="flex gap-3">
                                <span class="text-xl mt-0.5">{{ $r['correct'] ? '✅' : '❌' }}</span>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-800 mb-3">{{ $index + 1 }}. {{ $q['question'] }}</p>
                                    @if($q['type'] === 'qcm')
                                        <div class="space-y-2">
                                            @foreach($q['options'] as $i => $option)
                                                <div class="text-sm px-3 py-2 rounded-lg
                                                    {{ $i == $q['bonne_reponse'] ? 'bg-green-100 text-green-800 font-semibold' : '' }}
                                                    {{ $i == $r['reponse_user'] && !$r['correct'] ? 'bg-red-100 text-red-700' : '' }}">
                                                    {{ $option }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex gap-3 text-sm">
                                            @foreach(['Vrai', 'Faux'] as $choix)
                                                <div class="px-4 py-2 rounded-lg
                                                    {{ $choix === $q['bonne_reponse'] ? 'bg-green-100 text-green-800 font-semibold' : '' }}
                                                    {{ $choix === $r['reponse_user'] && !$r['correct'] ? 'bg-red-100 text-red-700' : '' }}">
                                                    {{ $choix }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    @if(!empty($r['explication']))
                                        <p class="text-sm text-gray-600 mt-2"><span class="font-semibold">À retenir —</span> {{ $r['explication'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="flex gap-4">
                    @if(!$reussi)
                        <a href="{{ route('parcours.test', $parcours) }}" class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl font-bold text-lg">Refaire le test</a>
                    @endif
                    <a href="{{ route('parcours.show', $parcours) }}" class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg">Retour à la formation</a>
                </div>

            @else
                {{-- ───────── L'EXAMEN ───────── --}}
                <form action="{{ route('parcours.test.check', $parcours) }}" method="POST" class="space-y-5">
                    @csrf
                    <p class="text-gray-600">Réponds à toutes les questions, puis valide. Tu peux refaire le test autant de fois que nécessaire.</p>

                    @foreach($questions as $index => $q)
                        <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                            <p class="font-semibold text-gray-800 mb-4">{{ $index + 1 }}. {{ $q['question'] }}</p>

                            @if($q['type'] === 'qcm')
                                <div class="space-y-3">
                                    @foreach($q['options'] as $i => $option)
                                        <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all">
                                            <input type="radio" name="reponses[{{ $q['id'] }}]" value="{{ $i }}" class="w-4 h-4 text-blue-600" required>
                                            <span class="ml-3 text-gray-700">{{ $option }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @else
                                <div class="flex gap-4">
                                    <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 hover:border-green-400 transition-all font-semibold text-gray-700">
                                        <input type="radio" name="reponses[{{ $q['id'] }}]" value="Vrai" class="mr-2" required> Vrai
                                    </label>
                                    <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-400 transition-all font-semibold text-gray-700">
                                        <input type="radio" name="reponses[{{ $q['id'] }}]" value="Faux" class="mr-2"> Faux
                                    </label>
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-4 rounded-2xl font-bold text-xl shadow-lg transition-all active:scale-95">
                        Valider le test final
                    </button>
                </form>
            @endif

        </div>
    </div>
</x-app-layout>
