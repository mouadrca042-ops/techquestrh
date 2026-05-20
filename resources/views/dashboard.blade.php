<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            {{-- BIENVENUE & PROFIL HEADER --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" class="w-20 h-20 rounded-2xl object-cover border-4 border-indigo-50 shadow-md">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=6366F1&color=ffffff&size=128" class="w-20 h-20 rounded-2xl border-4 border-indigo-50 shadow-md">
                        @endif
                    </div>
                    <div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Espace Employé Senior</span>
                        <h2 class="text-3xl font-black text-gray-900 mt-1">Ravi de vous revoir, {{ $user->name }} !</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Prêt à relever de nouveaux défis et à perfectionner vos compétences aujourd'hui ?</p>
                    </div>
                </div>

                {{-- STATS RAPIDES (GAMIFICATION) --}}
                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 min-w-[280px]">
                    <div class="p-3 bg-amber-100 rounded-xl text-amber-600 text-2xl">⭐</div>
                    <div>
                        <div class="text-2xl font-black text-gray-900">{{ $user->xp_total ?? 0 }} XP</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Niveau actuel : {{ $user->niveau ?? 'Débutant' }}</div>
                    </div>
                </div>
            </div>

            {{-- GRILLE PRINCIPALE --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- COLONNE GAUCHE : VOS PROGRÈS GLOBAUX --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-4">Vue d'ensemble de votre formation</h3>
                        
                        <div class="space-y-2">
                            <div class="flex justify-between items-center text-sm font-semibold">
                                <span class="text-gray-600">Complétion globale</span>
                                <span class="text-indigo-600 font-bold text-lg">{{ $progressionGlobale }}%</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden border border-gray-200">
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-4 rounded-full transition-all duration-500" style="width: {{ $progressionGlobale }}%"></div>
                            </div>
                        </div>
                    </div>

                    {{-- PARCOURS RECOMMANDÉS / RECENT --}}
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-4">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-bold text-gray-900">Vos formations en cours</h3>
                            <a href="{{ route('parcours.index') }}" class="text-sm font-bold text-indigo-600 hover:underline">Voir le catalogue entier →</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($parcoursEnCours as $p)
                                <div class="border border-gray-100 rounded-2xl p-5 bg-gray-50/50 hover:shadow-md transition-all flex flex-col justify-between">
                                    <div>
                                        <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-md {{ $p->titre == 'Les Fondamentaux d\'Excel' ? 'bg-green-50 text-green-700' : 'bg-blue-50 text-blue-700' }}">
                                            {{ $p->titre == 'Les Fondamentaux d\'Excel' ? 'Excel' : 'Teams' }}
                                        </span>
                                        <h4 class="font-bold text-gray-900 text-lg mt-3">{{ $p->titre }}</h4>
                                    </div>
                                    <div class="mt-5">
                                        <a href="{{ route('parcours.show', $p->id) }}" class="w-full text-center block bg-white border border-gray-200 hover:border-indigo-500 hover:text-indigo-600 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm transition-all">
                                            Reprendre la formation
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- COLONNE DROITE : BADGES & CERTIFICATIONS --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 space-y-6">
                    <h3 class="text-xl font-bold text-gray-900">Vos Badges RH</h3>
                    
                <div class="grid grid-cols-2 gap-4">
                    {{-- Badge Excel : Débloqué si progressionExcel atteint 100% (ou 67% selon ton choix de test) --}}
                    <div class="flex flex-col items-center text-center p-4 rounded-2xl {{ $progressionExcel >= 67 ? 'bg-amber-50/60 border border-amber-100' : 'bg-gray-50 opacity-40' }}">
                        <div class="text-4xl mb-2">🥇</div>
                        <span class="text-sm font-bold text-gray-800">Analyste Excel</span>
                        <span class="text-xs text-amber-700 font-medium mt-0.5">{{ $progressionExcel >= 67 ? 'Obtenu' : 'Verrouillé' }}</span>
                    </div>

                    {{-- Badge Teams : Débloqué uniquement si progressionTeams atteint 100% --}}
                    <div class="flex flex-col items-center text-center p-4 rounded-2xl {{ $progressionTeams >= 100 ? 'bg-blue-50/60 border border-blue-100' : 'bg-gray-50 opacity-40 border border-dashed border-gray-200' }}">
                        <div class="text-4xl mb-2">💬</div>
                        <span class="text-sm font-bold {{ $progressionTeams >= 100 ? 'text-gray-800' : 'text-gray-400' }}">Pro Teams</span>
                        <span class="text-xs {{ $progressionTeams >= 100 ? 'text-blue-700' : 'text-gray-400' }} font-medium mt-0.5">
                            {{ $progressionTeams >= 100 ? 'Obtenu' : 'Verrouillé' }}
                        </span>
                    </div>
                </div> 

                    <div class="pt-4 border-t border-gray-100 text-center">
                        <p class="text-xs text-gray-400 font-medium">Atteignez 100% dans un parcours pour débloquer sa certification officielle.</p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
