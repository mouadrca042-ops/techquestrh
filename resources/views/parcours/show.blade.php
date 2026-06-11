<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ $parcours->titre }}
            </h2>
            <a href="{{ route('parcours.index') }}" class="text-blue-600 hover:underline font-semibold text-sm">
                &larr; Retour au catalogue
            </a>
        </div>
    </x-slot>

    <div class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if(session('success'))
                <div id="msg-success" class="bg-green-50 border border-green-200 text-green-800 rounded-xl px-6 py-4 mb-6 font-medium transition-opacity duration-500">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('explication'))
                <div id="msg-explication" class="bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-6 py-4 mb-6 transition-opacity duration-500">
                    {{ session('explication') }}
                </div>
            @endif
            @if(session('positionnement'))
                @php
                    $couleurs = [
                        'debutant'      => 'bg-green-50 border-green-200 text-green-800',
                        'intermediaire' => 'bg-amber-50 border-amber-200 text-amber-800',
                        'expert'        => 'bg-rose-50 border-rose-200 text-rose-800',
                    ];
                    $c = $couleurs[session('positionnement')] ?? 'bg-gray-50 border-gray-200 text-gray-800';
                @endphp
                <div id="msg-positionnement" class="border rounded-xl px-6 py-4 mb-6 font-medium transition-opacity duration-500 {{ $c }}">
                    {{ session('positionnement_message') }}
                </div>
            @endif

            {{-- ── En-tête de la formation ──────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-200 p-8 mb-6">
                <div class="flex items-start justify-between gap-6 flex-wrap">
                    <div class="flex-1 min-w-[260px]">
                        <div class="flex items-center gap-4 mb-3">
                            <x-formation-logo :outil="$parcours->outil" size="lg" />
                            <span class="inline-block text-xs font-bold uppercase tracking-wider text-blue-700 bg-blue-50 px-3 py-1 rounded-full">
                                {{ $parcours->outil }}
                            </span>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $parcours->titre }}</h1>
                        <p class="text-gray-600 mt-2 leading-relaxed">{{ $parcours->description }}</p>

                        <div class="flex items-center gap-6 mt-5 text-sm text-gray-500">
                            <span><span class="font-bold text-gray-900">{{ $total }}</span> modules</span>
                            <span><span class="font-bold text-gray-900">{{ $completes }}</span> terminés</span>
                            @if($niveauDepart)
                                <span class="capitalize">Niveau de départ : <span class="font-semibold text-gray-700">{{ $niveauDepart }}</span></span>
                            @endif
                        </div>
                    </div>

                    {{-- Avancement --}}
                    <div class="w-44 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $progression }}%</div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Avancement</div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-700" style="width: {{ $progression }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Inscription si pas encore commencé --}}
                @if(!$inscrit)
                    <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between gap-4 flex-wrap">
                        <p class="text-sm text-gray-600">Un court test de positionnement orientera votre niveau de départ.</p>
                        <form action="{{ route('parcours.choisir', $parcours) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-bold shadow-sm transition active:scale-95">
                                Commencer la formation
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- ── Programme : modules dans l'ordre ─────────────────── --}}
            <h3 class="text-lg font-bold text-gray-900 mb-4 ml-1">Programme de la formation</h3>

            @php
                $niveauMeta = [
                    'debutant'      => ['label' => 'Débutant',      'classe' => 'bg-green-100 text-green-700'],
                    'intermediaire' => ['label' => 'Intermédiaire', 'classe' => 'bg-amber-100 text-amber-700'],
                    'expert'        => ['label' => 'Expert',        'classe' => 'bg-rose-100 text-rose-700'],
                ];
            @endphp

            <div class="space-y-3">
                @forelse($modules as $module)
                    @php
                        $meta = $niveauMeta[$module->niveau] ?? ['label' => ucfirst($module->niveau), 'classe' => 'bg-gray-100 text-gray-700'];
                        $objectif = $module->contenu_json['objectif'] ?? null;
                        $duree = $module->contenu_json['lecon']['duree'] ?? null;
                        $verrou = $module->verrouille ?? false;
                        $estDepart = $niveauDepart && $module->niveau === $niveauDepart && !$module->est_complete && !$verrou;
                        $niveauPrerequis = $module->niveau === 'intermediaire' ? 'Débutant'
                                         : ($module->niveau === 'expert' ? 'Intermédiaire' : null);
                    @endphp

                    <div class="bg-white rounded-xl border p-5 flex items-center justify-between gap-4
                        {{ $verrou ? 'border-gray-200 opacity-60' : ($module->est_complete ? 'border-green-200' : ($estDepart ? 'border-blue-300 ring-1 ring-blue-100' : 'border-gray-200')) }}">

                        <div class="flex items-start gap-4 min-w-0">
                            {{-- Numéro / état du module --}}
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center font-bold text-sm
                                {{ $module->est_complete ? 'bg-green-600 text-white' : ($verrou ? 'bg-gray-100 text-gray-400' : 'bg-gray-100 text-gray-600') }}">
                                {{ $module->est_complete ? '✓' : ($verrou ? '🔒' : $loop->iteration) }}
                            </div>

                            <div class="min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Module {{ $loop->iteration }}</span>
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full {{ $meta['classe'] }}">{{ $meta['label'] }}</span>
                                    @if($module->est_complete)
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 text-green-700">Terminé ✓</span>
                                    @elseif($module->en_cours)
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700">En cours · Question {{ $module->question_courante + 1 }}/{{ $module->nb_questions }}</span>
                                    @elseif($estDepart)
                                        <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-blue-600 text-white">Conseillé pour vous</span>
                                    @endif
                                </div>
                                <h4 class="text-base font-bold text-gray-900 mt-1">{{ $module->titre }}</h4>
                                @if($objectif)
                                    <p class="text-sm text-gray-500 mt-0.5">{{ $objectif }}</p>
                                @endif
                                <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                                    @if($duree)<span>{{ $duree }} de lecture</span>@endif
                                    <span>+{{ $module->xp_recompense }} XP</span>
                                    @if($verrou && $niveauPrerequis)
                                        <span>🔒 Terminez le niveau {{ $niveauPrerequis }} d'abord</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex-shrink-0 text-right">
                            @if($verrou)
                                <span class="inline-flex items-center gap-1 text-sm text-gray-400 font-medium">🔒 Verrouillé</span>
                            @elseif($module->est_complete)
                                <a href="{{ route('defis.show', $module->id) }}" class="text-sm font-semibold text-green-700 hover:underline">Revoir</a>
                            @elseif($module->en_cours)
                                <a href="{{ route('defis.show', $module->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition active:scale-95 inline-block">
                                    Continuer
                                </a>
                            @else
                                <a href="{{ route('defis.show', $module->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold text-sm shadow-sm transition active:scale-95 inline-block">
                                    Commencer
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-xl border border-dashed border-gray-200">
                        <p class="text-gray-500">Le programme de cette formation sera bientôt disponible.</p>
                    </div>
                @endforelse
            </div>

            {{-- ── Test final de la formation (badge secret) ── --}}
            @if($inscrit)
                <div class="mt-6">
                    @if($tousTermines)
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 border-2 border-purple-200 rounded-2xl p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-purple-600 text-white flex items-center justify-center text-2xl shrink-0">🏆</div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Test final de la formation</h3>
                                    <p class="text-sm text-gray-600">Tous les modules sont terminés ! Réussis l'examen pour décrocher le <span class="font-semibold text-purple-700">badge secret 🏅</span>.</p>
                                </div>
                            </div>
                            @if($examenReussi)
                                <span class="px-4 py-2 bg-green-100 text-green-800 rounded-xl font-bold whitespace-nowrap">✓ Test final réussi</span>
                            @else
                                <a href="{{ route('parcours.test', $parcours) }}"
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl font-bold shadow-sm transition active:scale-95 whitespace-nowrap">
                                    Passer le test final →
                                </a>
                            @endif
                        </div>
                    @else
                        <div class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-2xl p-6 flex items-center gap-4">
                            <div class="w-12 h-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center text-2xl shrink-0">🔒</div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-500">Test final de la formation — verrouillé</h3>
                                <p class="text-sm text-gray-400">Termine <span class="font-semibold">tous les modules</span> ({{ $completes }}/{{ $total }}) pour débloquer l'examen final et le badge secret.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if(!$inscrit && $modules->isNotEmpty())
                <p class="text-center text-sm text-gray-400 mt-4">Commencez la formation pour débloquer les modules.</p>
            @endif

        </div>
    </div>

    <script>
        setTimeout(function () {
            ['msg-success', 'msg-explication', 'msg-positionnement'].forEach(function (id) {
                var el = document.getElementById(id);
                if (el) { el.style.opacity = '0'; setTimeout(function () { el.style.display = 'none'; }, 500); }
            });
        }, 4000);
    </script>
</x-app-layout>
