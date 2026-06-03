<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- 1. BIENVENUE & PROFIL HEADER --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="h-20 w-20 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-3xl font-bold">
                            {{ substr($user->name, 0, 2) }}
                        </div>
                    </div>
                    <div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Espace Employé senior</span>
                        <h2 class="text-3xl font-black text-gray-900 mt-1">Ravi de vous revoir, {{ $user->name }} !</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Prêt à relever de nouveaux défis et à perfectionner vos compétences aujourd'hui ?</p>
                    </div>
                </div>

                {{-- STATS RAPIDES (GAMIFICATION) --}}
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 min-w-[180px]">
                        <div class="p-3 bg-amber-100 rounded-xl text-amber-600 text-2xl">⭐</div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">{{ $progressionGlobale }}%</div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Progression Globale</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl border border-gray-100 min-w-[180px]">
                        <div class="p-3 bg-green-100 rounded-xl text-green-600 text-2xl">⚡</div>
                        <div>
                            <div class="text-2xl font-black text-gray-900">Débutant</div>
                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Niveau actuel</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. GRILLE DES PARCOURS EN COURS --}}
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Nos parcours de formation</h3>
                    <span class="text-sm font-medium text-gray-500">"Excellent travail. Continuez ainsi !"</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($parcoursEnCours as $p)
                        <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between hover:shadow-lg hover:border-blue-300 transition duration-300">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-2xl font-bold text-blue-900">{{ $p->titre }}</h4>
                                    <span class="bg-blue-100 text-blue-800 text-sm font-bold px-4 py-2 rounded-full uppercase">{{ $p->outil }}</span>
                                </div>
                                <p class="text-gray-600 text-lg mb-8 min-h-[60px]">{{ $p->description }}</p>
                            </div>

                            <div class="mt-4">
                                <div class="flex justify-between text-sm font-bold text-gray-500 mb-2">
                                    <span>Progression</span>
                                    <span>{{ $p->titre == 'Les Fondamentaux d\'Excel' ? $progressionExcel : $progressionTeams }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $p->titre == 'Les Fondamentaux d\'Excel' ? $progressionExcel : $progressionTeams }}%"></div>
                                </div>
                                <a href="{{ route('parcours.show', $p->id) }}" class="mt-6 inline-flex w-full justify-center bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition shadow-md">
                                    Reprendre le parcours
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

