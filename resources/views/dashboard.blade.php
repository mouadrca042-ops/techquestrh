<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. BIENVENUE & PROFIL HEADER --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Espace Employé</span>
                        <h2 class="text-3xl font-black text-gray-900 mt-1">Ravi de vous revoir, {{ $user->name }} !</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Prêt à relever de nouveaux défis et à perfectionner vos compétences aujourd'hui ?</p>
                    </div>
                </div>

                {{-- STATS RAPIDES --}}
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 min-w-[180px]">
                        <div class="p-3 bg-amber-100 rounded-xl text-amber-600 text-2xl">⭐</div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">{{ $progressionGlobale }}%</div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Progression globale</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 min-w-[180px]">
                        <div class="p-3 bg-green-100 rounded-xl text-green-600 text-2xl">🏆</div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">{{ ucfirst($user->niveau ?? 'Débutant') }}</div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Niveau actuel</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. MON APPRENTISSAGE : uniquement les formations déjà commencées --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900">Mon apprentissage</h3>
                        <p class="text-sm text-gray-500 mt-0.5">Reprenez là où vous vous êtes arrêté.</p>
                    </div>
                    <a href="{{ route('parcours.index') }}" class="text-sm font-semibold text-blue-600 hover:underline whitespace-nowrap">
                        Explorer les formations →
                    </a>
                </div>

                @if($monApprentissage->isEmpty())
                    <div class="text-center py-14 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <p class="text-gray-800 font-bold text-lg">Vous n'avez pas encore commencé de formation</p>
                        <p class="text-gray-500 text-sm mt-1 mb-5">Choisissez une formation dans le catalogue pour démarrer votre apprentissage.</p>
                        <a href="{{ route('parcours.index') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md">
                            Découvrir les formations
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($monApprentissage as $p)
                            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 border border-green-300 transition flex flex-col hover:shadow-2xl">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex items-center gap-3">
                                        <x-formation-logo :outil="$p->outil" size="md" />
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm font-bold uppercase">
                                            {{ $p->outil }}
                                        </span>
                                    </div>
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase">
                                        En cours
                                    </span>
                                </div>

                                <h3 class="text-2xl font-bold text-gray-900 mb-3">{{ $p->titre }}</h3>
                                <p class="text-gray-600 text-lg mb-5 line-clamp-3">{{ $p->description }}</p>

                                {{-- Modules par niveau de difficulté --}}
                                <div class="flex flex-wrap gap-2 mb-5">
                                    @if($p->defis_debutant)
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">{{ $p->defis_debutant }} Débutant</span>
                                    @endif
                                    @if($p->defis_intermediaire)
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-700">{{ $p->defis_intermediaire }} Intermédiaire</span>
                                    @endif
                                    @if($p->defis_expert)
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-700">{{ $p->defis_expert }} Expert</span>
                                    @endif
                                </div>

                                {{-- Progression --}}
                                <div class="mb-5">
                                    <div class="flex justify-between text-sm font-bold text-gray-500 mb-2">
                                        <span>Progression</span>
                                        <span>{{ $p->progression }}%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-green-600 h-2.5 rounded-full transition-all duration-700" style="width: {{ $p->progression }}%"></div>
                                    </div>
                                </div>

                                <a href="{{ route('parcours.show', $p->id) }}"
                                   class="mt-auto inline-flex w-full justify-center items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-bold text-lg text-white hover:bg-green-700 transition ease-in-out duration-150">
                                    {{ $p->progression > 0 ? 'Continuer' : 'Commencer' }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
