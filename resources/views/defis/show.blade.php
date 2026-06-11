<x-app-layout>
    @php
        $contenu     = $defi->contenu_json;            // array via cast
        $lecon       = $contenu['lecon'];
        $objectif    = $contenu['objectif'] ?? null;
        $sections    = $lecon['sections'] ?? [];        // chaque section = un élément
        $nbSous      = count($sections);
        $questions   = $contenu['questions'];
        $nbQuestions = count($questions);

        $moduleTermine = $progression && $progression->completed_at !== null;
        // Question en cours (sauvegardée) = point de situation
        $qIndex = (int) ($progression->question_courante ?? 0);
        $qIndex = max(0, min($qIndex, $nbQuestions - 1));
        $questionCourante = $questions[$qIndex];
        // Indice : champ dédié si présent, sinon repli sur l'explication
        $indice = $questionCourante['indice'] ?? $questionCourante['explication'] ?? null;

        // On ouvre directement le quiz si l'employé est en train de le faire / vient d'y répondre
        $enCoursQuiz = $progression && $progression->question_courante > 0 && ! $moduleTermine;
        $surQuiz     = $moduleTermine || $enCoursQuiz || session()->hasAny(['reponse_correcte', 'module_termine', 'message']);
    @endphp

    {{-- Évite le flash des panneaux avant l'initialisation d'Alpine --}}
    <style>[x-cloak]{display:none!important}</style>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{ etape: {{ $surQuiz ? "'quiz'" : '0' }}, total: {{ $nbSous }}, lus: [] }"
             x-effect="if (typeof etape === 'number' && ! lus.includes(etape)) lus.push(etape)">

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
                    @if($moduleTermine)
                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                            ✓ Module validé
                        </span>
                    @endif
                </div>
            </div>

            <div class="grid lg:grid-cols-[280px_1fr] gap-6">

                {{-- SOMMAIRE : éléments numérotés + quiz --}}
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
                                    <span :class="etape === {{ $i }} ? 'bg-blue-600 text-white' : (lus.includes({{ $i }}) ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-500')"
                                          class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm"
                                          x-text="(lus.includes({{ $i }}) && etape !== {{ $i }}) ? '✓' : '{{ $i + 1 }}'">{{ $i + 1 }}</span>
                                    <span class="text-sm font-semibold leading-tight">{{ $section['titre'] }}</span>
                                </button>
                            </li>
                        @endforeach
                        <li class="pt-1 mt-1 border-t border-gray-100">
                            <button type="button" @click="etape = 'quiz'"
                                    :class="etape === 'quiz' ? 'bg-green-50 text-green-900 border-green-200' : 'border-transparent text-gray-600 hover:bg-gray-50'"
                                    class="w-full flex items-center gap-3 text-left border rounded-xl px-3 py-2.5 transition">
                                <span :class="etape === 'quiz' ? 'bg-green-600 text-white' : 'bg-gray-100 text-gray-500'"
                                      class="flex-shrink-0 w-7 h-7 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ $moduleTermine ? '✓' : '?' }}
                                </span>
                                <span class="text-sm font-semibold leading-tight">
                                    Test du module
                                    <span class="block text-xs font-normal opacity-70">
                                        @if($moduleTermine)
                                            Réussi ✓
                                        @else
                                            Question {{ $qIndex + 1 }} / {{ $nbQuestions }}
                                        @endif
                                    </span>
                                </span>
                            </button>
                        </li>
                    </ol>
                </aside>

                {{-- CONTENU --}}
                <div>

                    {{-- ── Éléments (sections numérotées) ──────────── --}}
                    @foreach($sections as $i => $section)
                        <div x-show="etape === {{ $i }}" x-cloak class="space-y-6">
                            <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
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

                    {{-- ── QUIZ : une question à la fois ───────────── --}}
                    <div x-show="etape === 'quiz'" x-cloak class="space-y-6">

                        {{-- 🎉 Badge(s) fraîchement débloqué(s) --}}
                        @if(session('nouveaux_badges'))
                            <div x-data="{ show: true }" x-show="show" x-transition.scale
                                 class="relative bg-gradient-to-r from-amber-50 to-yellow-50 border-2 border-amber-300 rounded-2xl p-6 text-center shadow-md">
                                <button type="button" @click="show = false"
                                        class="absolute top-3 right-4 text-amber-400 hover:text-amber-700 text-2xl leading-none">&times;</button>
                                <p class="text-2xl font-black text-amber-800">🎉 Félicitations !</p>
                                <p class="text-amber-700 mb-4">
                                    Tu viens de débloquer {{ count(session('nouveaux_badges')) > 1 ? 'de nouveaux badges' : 'un nouveau badge' }} :
                                </p>
                                <div class="flex flex-wrap justify-center gap-6 mb-5">
                                    @foreach(session('nouveaux_badges') as $b)
                                        <div class="flex flex-col items-center">
                                            <x-badge-icon :type="$b['type']" :unlocked="true" size="md" />
                                            <span class="mt-2 font-bold text-amber-900">{{ $b['titre'] }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                <a href="{{ route('badges.index') }}"
                                   class="inline-block bg-amber-500 hover:bg-amber-600 text-white font-bold px-6 py-2.5 rounded-xl transition">
                                    Voir mes badges →
                                </a>
                            </div>
                        @endif

                        @if($moduleTermine)
                            {{-- ✅ Module validé --}}
                            <div class="bg-green-50 border-2 border-green-300 rounded-2xl p-8 text-center">
                                <div class="text-5xl mb-2">🎉</div>
                                <div class="text-2xl font-black text-green-700">Module validé — félicitations !</div>
                                <p class="text-green-700 mt-1">Tu as répondu correctement à toutes les questions.</p>
                            </div>
                            <a href="{{ route('parcours.show', $defi->parcours_id) }}"
                               class="block text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold text-lg transition-all">
                                Continuer la formation →
                            </a>
                        @else
                            {{-- Question courante --}}
                            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm"
                                 x-data="{ showIndice: false }">

                                {{-- Barre de progression --}}
                                <div class="flex items-center justify-between gap-4 mb-5">
                                    <span class="text-xs font-bold uppercase tracking-wider text-blue-500 whitespace-nowrap">
                                        Question {{ $qIndex + 1 }} / {{ $nbQuestions }}
                                    </span>
                                    <div class="flex-1 bg-gray-100 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                                             style="width: {{ $nbQuestions ? round(($qIndex / $nbQuestions) * 100) : 0 }}%"></div>
                                    </div>
                                </div>

                                {{-- Feedback de la tentative précédente --}}
                                @if(session('reponse_correcte') === true)
                                    <div class="bg-green-50 border border-green-300 text-green-800 rounded-xl px-4 py-3 mb-4 font-semibold">
                                        ✅ {{ session('message') ?? 'Bonne réponse !' }}
                                    </div>
                                @elseif(session('reponse_correcte') === false)
                                    <div class="bg-orange-50 border border-orange-300 text-orange-800 rounded-xl px-4 py-3 mb-4">
                                        <span class="font-semibold">{{ session('message') ?? "Pas tout à fait — réessaie, tu vas y arriver !" }}</span>
                                        @if($indice)
                                            <span class="block text-sm mt-1 text-orange-600">Besoin d'un coup de pouce ? Affiche l'indice ci-dessous 👇</span>
                                        @endif
                                    </div>
                                @endif

                                <p class="font-semibold text-gray-900 text-lg mb-5">{{ $questionCourante['question'] }}</p>

                                <form action="{{ route('defis.check', $defi->id) }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="question_index" value="{{ $qIndex }}">

                                    @if($questionCourante['type'] === 'qcm')
                                        <div class="space-y-3">
                                            @foreach($questionCourante['options'] as $i => $option)
                                                <label class="flex items-center p-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all">
                                                    <input type="radio" name="reponse" value="{{ $i }}" class="w-4 h-4 text-blue-600" required>
                                                    <span class="ml-3 text-gray-700">{{ $option }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="flex gap-4">
                                            <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-green-50 hover:border-green-400 transition-all font-semibold text-gray-700">
                                                <input type="radio" name="reponse" value="Vrai" class="mr-2" required> Vrai
                                            </label>
                                            <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-red-50 hover:border-red-400 transition-all font-semibold text-gray-700">
                                                <input type="radio" name="reponse" value="Faux" class="mr-2"> Faux
                                            </label>
                                        </div>
                                    @endif

                                    {{-- Bouton indice (optionnel, à la demande) --}}
                                    @if($indice)
                                        <div>
                                            <button type="button" @click="showIndice = ! showIndice"
                                                    class="text-sm font-semibold text-amber-700 hover:text-amber-900 inline-flex items-center gap-1">
                                                💡 <span x-text="showIndice ? 'Masquer l\'indice' : 'Afficher l\'indice'"></span>
                                            </button>
                                            <div x-show="showIndice" x-cloak class="mt-2 bg-amber-50 border-l-4 border-amber-400 rounded-r-lg px-4 py-3 text-amber-800 text-sm">
                                                {{ $indice }}
                                            </div>
                                        </div>
                                    @endif

                                    <div class="flex gap-4 pt-2">
                                        <button type="button" @click="etape = {{ max($nbSous - 1, 0) }}"
                                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all">
                                            ← Leçon
                                        </button>
                                        <button type="submit"
                                                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-bold text-lg shadow-md transition-all active:scale-95">
                                            Valider
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <p class="text-center text-sm text-gray-400">
                                Aucune pénalité : tu peux réessayer autant de fois que nécessaire. Ta progression est sauvegardée 💾
                            </p>
                        @endif

                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
