<x-app-layout>
    @php
        $contenu   = $defi->contenu_json;            // array via cast
        $lecon     = $contenu['lecon'];
        $objectif  = $contenu['objectif'] ?? null;
        $sections  = $lecon['sections'] ?? [];        // chaque section = un élément
        $nbSous    = count($sections);
        $questions = $contenu['questions'];
        $resultats = session('resultats');            // null ou array indexé par question id
        $score     = session('score');                // null ou int 0-100
        $reussi    = $score !== null && $score >= 70;
        // On démarre sur le quiz au retour d'une soumission, sinon sur le 1er élément.
        $surQuiz   = $resultats || $score !== null;
    @endphp

    {{-- Évite le flash des panneaux avant l'initialisation d'Alpine --}}
    <style>[x-cloak]{display:none!important}</style>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{ etape: {{ $surQuiz ? "'quiz'" : '0' }}, total: {{ $nbSous }} }">

            {{-- ── En-tête du module ───────────────────────────── --}}
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-start gap-4">
                    <x-formation-logo :outil="$defi->parcours->outil" size="lg" class="mt-1" />
                    <div>
                        <a href="{{ route('parcours.show', $defi->parcours_id) }}"
                           class="text-sm text-blue-600 hover:underline mb-1 inline-block">
                            ← Retour à la formation
                        </a>
                        <h1 class="text-2xl font-black text-gray-900">{{ $defi->titre }}</h1>
                        @if($objectif)
                            <p class="text-gray-500 mt-1 max-w-2xl">{{ $objectif }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col items-end gap-1 shrink-0 ml-4">
                    <span class="text-xs font-semibold px-3 py-1 rounded-full
                        {{ $defi->niveau === 'debutant'      ? 'bg-green-100 text-green-700'  : '' }}
                        {{ $defi->niveau === 'intermediaire' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $defi->niveau === 'expert'        ? 'bg-red-100 text-red-700'      : '' }}">
                        {{ ucfirst($defi->niveau) }}
                    </span>
                    <span class="text-xs font-semibold px-3 py-1 rounded-full bg-purple-100 text-purple-700">
                        +{{ $defi->xp_recompense }} XP
                    </span>
                    @if($progression && $progression->completed_at)
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                            ✓ Complété — {{ $progression->score }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid lg:grid-cols-[280px_1fr] gap-6">

                {{-- ════════════════════════════════════════════════ --}}
                {{-- SOMMAIRE : éléments numérotés + quiz             --}}
                {{-- ════════════════════════════════════════════════ --}}
                <aside class="lg:sticky lg:top-6 self-start bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                    <p class="text-xs font-bold uppercase tracking-wider text-gray-400 px-2 mb-3">
                        Éléments du module
                        @if(!empty($lecon['duree'])) · {{ $lecon['duree'] }} @endif
                    </p>
                    <ol class="space-y-1">
                        @foreach($sections as $i => $section)
                            <li>
                                <button type="button" @click="etape = {{ $i }}"
                                        :class="etape === {{ $i }} ? 'bg-blue-50 text-blue-900 border-blue-200' : 'border-transparent text-gray-600 hover:bg-gray-50'"
                                        class="w-full flex items-center gap-3 text-left border rounded-xl px-3 py-2.5 transition">
                                    <span :class="etape === {{ $i }} ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-500'"
                                          class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm">
                                        {{ $i + 1 }}
                                    </span>
                                    <span class="text-sm font-semibold leading-tight">{{ $section['titre'] }}</span>
                                </button>
                            </li>
                        @endforeach
                        <li class="pt-1 mt-1 border-t border-gray-100">
                            <button type="button" @click="etape = 'quiz'"
                                    :class="etape === 'quiz' ? 'bg-green-50 text-green-900 border-green-200' : 'border-transparent text-gray-600 hover:bg-gray-50'"
                                    class="w-full flex items-center gap-3 text-left border rounded-xl px-3 py-2.5 transition">
                                <span :class="etape === 'quiz' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-500'"
                                      class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm">✓</span>
                                <span class="text-sm font-semibold leading-tight">
                                    Quiz
                                    <span class="block text-xs font-normal opacity-70">{{ count($questions) }} questions</span>
                                </span>
                            </button>
                        </li>
                    </ol>
                </aside>

                {{-- ════════════════════════════════════════════════ --}}
                {{-- CONTENU : un panneau par élément, puis quiz      --}}
                {{-- ════════════════════════════════════════════════ --}}
                <div>

                    {{-- ── Éléments (sections numérotées) ──────────── --}}
                    @foreach($sections as $i => $section)
                        <div x-show="etape === {{ $i }}" x-cloak class="space-y-6">
                            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">

                                {{-- Introduction affichée sur le 1er élément --}}
                                @if($i === 0 && !empty($lecon['intro']))
                                    <p class="text-gray-700 leading-relaxed text-lg mb-6 pb-6 border-b border-gray-100">{{ $lecon['intro'] }}</p>
                                @endif

                                <p class="text-xs font-bold uppercase tracking-wider text-blue-500 mb-1">
                                    Élément {{ $i + 1 }} / {{ $nbSous }}
                                </p>
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $section['titre'] }}</h2>

                                @if(!empty($section['corps']))
                                    <p class="text-gray-700 leading-relaxed">{{ $section['corps'] }}</p>
                                @endif

                                @if(!empty($section['liste']))
                                    <ul class="mt-4 space-y-2">
                                        @foreach($section['liste'] as $puce)
                                            <li class="flex items-start gap-2 text-gray-700">
                                                <span class="text-blue-500 mt-1 shrink-0">▸</span>
                                                <span>{{ $puce }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if(!empty($section['astuce']))
                                    <div class="mt-5 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg px-4 py-3 text-amber-800 text-sm">
                                        <span class="font-semibold">Bon à savoir —</span> {{ $section['astuce'] }}
                                    </div>
                                @endif

                                {{-- Points clés affichés sur le dernier élément --}}
                                @if($i === $nbSous - 1 && !empty($lecon['resume']))
                                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-5">
                                        <h3 class="font-bold text-blue-900 mb-3 text-xs uppercase tracking-wider">Points clés à retenir</h3>
                                        <ul class="space-y-2">
                                            @foreach($lecon['resume'] as $point)
                                                <li class="flex items-start gap-2 text-blue-900">
                                                    <span class="mt-0.5 shrink-0 text-blue-600 font-bold">✓</span>
                                                    <span>{{ $point }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>

                            {{-- Navigation entre éléments --}}
                            <div class="flex gap-4">
                                @if($i > 0)
                                    <button type="button" @click="etape = {{ $i - 1 }}"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-4 rounded-2xl font-semibold transition-all">
                                        ← Précédent
                                    </button>
                                @endif
                                @if($i < $nbSous - 1)
                                    <button type="button" @click="etape = {{ $i + 1 }}"
                                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg transition-all active:scale-95">
                                        Élément suivant →
                                    </button>
                                @else
                                    <button type="button" @click="etape = 'quiz'"
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg transition-all active:scale-95">
                                        Passer au quiz →
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    {{-- ── Quiz (dernière étape) ───────────────────── --}}
                    <div x-show="etape === 'quiz'" x-cloak class="space-y-6">

                        {{-- Résultat global (après soumission) --}}
                        @if($score !== null)
                            @if($reussi)
                                <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-6 text-center">
                                    <div class="text-5xl font-black text-green-600 mb-1">{{ $score }}%</div>
                                    <div class="text-green-800 font-bold text-lg">Bravo, module validé !</div>
                                    @if(!($progression && $progression->score >= 70 && $progression->tentatives > 1))
                                        <div class="text-green-700 text-sm mt-1">+{{ $defi->xp_recompense }} XP ajoutés à votre profil</div>
                                    @endif
                                </div>
                            @else
                                <div class="bg-orange-50 border-2 border-orange-300 rounded-2xl p-6 text-center">
                                    <div class="text-5xl font-black text-orange-500 mb-1">{{ $score }}%</div>
                                    <div class="text-orange-800 font-bold text-lg">Pas encore ! Il faut 70 % pour valider.</div>
                                    @if(session('message_motivant'))
                                        <p class="text-orange-700 mt-2 max-w-xl mx-auto">{{ session('message_motivant') }}</p>
                                    @endif
                                    <button type="button" @click="etape = 0" class="inline-block text-orange-800 font-semibold text-sm mt-3 underline">
                                        Revoir les éléments
                                    </button>
                                </div>
                            @endif
                        @endif

                        @if($resultats)

                            {{-- MODE RÉSULTATS --}}
                            <div class="space-y-4">
                                <h2 class="text-lg font-bold text-gray-700">
                                    Correction — {{ count(array_filter($resultats, fn($r) => $r['correct'])) }}/{{ count($questions) }} bonnes réponses
                                </h2>

                                @foreach($questions as $index => $q)
                                    @php $r = $resultats[$q['id']]; @endphp
                                    <div class="bg-white border-2 rounded-2xl p-5
                                        {{ $r['correct'] ? 'border-green-300' : 'border-red-300' }}">

                                        <div class="flex gap-3">
                                            <span class="text-xl mt-0.5">{{ $r['correct'] ? '✅' : '❌' }}</span>
                                            <div class="flex-1">
                                                <p class="font-semibold text-gray-800 mb-3">
                                                    {{ $index + 1 }}. {{ $q['question'] }}
                                                </p>

                                                @if($q['type'] === 'qcm')
                                                    <div class="space-y-2">
                                                        @foreach($q['options'] as $i => $option)
                                                            <div class="flex items-center gap-2 text-sm px-3 py-2 rounded-lg
                                                                {{ $i == $q['bonne_reponse']            ? 'bg-green-100 text-green-800 font-semibold' : '' }}
                                                                {{ $i == $r['reponse_user'] && !$r['correct'] ? 'bg-red-100 text-red-700' : '' }}
                                                                {{ $i != $q['bonne_reponse'] && $i != $r['reponse_user'] ? 'text-gray-500' : '' }}">
                                                                @if($i == $q['bonne_reponse'])
                                                                    ✓
                                                                @elseif($i == $r['reponse_user'] && !$r['correct'])
                                                                    ✗
                                                                @else
                                                                    &nbsp;&nbsp;
                                                                @endif
                                                                {{ $option }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <div class="flex gap-3 text-sm">
                                                        @foreach(['Vrai', 'Faux'] as $choix)
                                                            <div class="px-4 py-2 rounded-lg
                                                                {{ $choix === $q['bonne_reponse']              ? 'bg-green-100 text-green-800 font-semibold' : '' }}
                                                                {{ $choix === $r['reponse_user'] && !$r['correct'] ? 'bg-red-100 text-red-700' : '' }}
                                                                {{ $choix !== $q['bonne_reponse'] && $choix !== $r['reponse_user'] ? 'text-gray-400' : '' }}">
                                                                @if($choix === $q['bonne_reponse']) ✓
                                                                @elseif($choix === $r['reponse_user'] && !$r['correct']) ✗
                                                                @endif
                                                                {{ $choix }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif

                                                @if(!$r['correct'])
                                                    @php
                                                        $encouragements = [
                                                            "Pas grave, on apprend en se trompant !",
                                                            "Presque ! Retenez bien ceci :",
                                                            "Ce n'est pas loin, voici la clé :",
                                                            "Continuez, vous progressez :",
                                                        ];
                                                    @endphp
                                                    <p class="text-sm font-semibold text-gray-700 mt-3">{{ $encouragements[array_rand($encouragements)] }}</p>
                                                @endif
                                                @if($r['explication'])
                                                    <p class="text-sm {{ $r['correct'] ? 'text-blue-700' : 'text-gray-600' }} mt-1">
                                                        <span class="font-semibold">À retenir —</span> {{ $r['explication'] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Boutons après résultats --}}
                            <div class="flex gap-4 pt-2">
                                @if($reussi)
                                    <a href="{{ route('parcours.show', $defi->parcours_id) }}"
                                       class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg transition-all">
                                        Continuer la formation →
                                    </a>
                                @else
                                    <a href="{{ route('defis.show', $defi->id) }}"
                                       class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl font-bold text-lg transition-all">
                                        Réessayer
                                    </a>
                                    <a href="{{ route('parcours.show', $defi->parcours_id) }}"
                                       class="text-center bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-4 rounded-2xl font-semibold text-lg transition-all">
                                        Formation
                                    </a>
                                @endif
                            </div>

                        @else

                            {{-- MODE QUIZ --}}
                            <form action="{{ route('defis.check', $defi->id) }}" method="POST" class="space-y-5">
                                @csrf

                                <h2 class="text-lg font-bold text-gray-700">
                                    Quiz du module — {{ count($questions) }} question{{ count($questions) > 1 ? 's' : '' }}
                                </h2>

                                @foreach($questions as $index => $q)
                                    <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                                        <p class="font-semibold text-gray-800 mb-4">
                                            {{ $index + 1 }}. {{ $q['question'] }}
                                        </p>

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
                                                    <input type="radio"
                                                           name="reponses[{{ $q['id'] }}]"
                                                           value="Vrai"
                                                           class="mr-2"
                                                           required>
                                                    Vrai
                                                </label>
                                                <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl
                                                              cursor-pointer hover:bg-red-50 hover:border-red-400 transition-all font-semibold text-gray-700">
                                                    <input type="radio"
                                                           name="reponses[{{ $q['id'] }}]"
                                                           value="Faux"
                                                           class="mr-2">
                                                    Faux
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="flex gap-4">
                                    <button type="button" @click="etape = {{ max($nbSous - 1, 0) }}"
                                            class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-4 rounded-2xl font-semibold text-lg transition-all">
                                        ← Éléments
                                    </button>
                                    <button type="submit"
                                            class="flex-1 bg-green-600 hover:bg-green-700 text-white py-4 rounded-2xl
                                                   font-bold text-xl shadow-lg transition-all active:scale-95">
                                        Valider mes réponses
                                    </button>
                                </div>
                            </form>

                        @endif

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
