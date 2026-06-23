<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- 1. BIENVENUE & PROFIL HEADER --}}
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center space-x-5">
                    <div class="flex-shrink-0">
                        <div class="h-16 w-16 bg-blue-600 rounded-2xl flex items-center justify-center text-white text-2xl font-bold">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    </div>
                    <div>
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wider">Espace Employé Senior</span>
                        <h2 class="text-3xl font-black text-gray-900 mt-1">Ravi de vous revoir, {{ $user->name }} !</h2>
                        <p class="text-gray-500 text-sm mt-0.5">Prêt à relever de nouveaux défis et à perfectionner vos compétences aujourd'hui ?</p>
                    </div>
                </div>

                {{-- XP --}}
                <div class="flex items-center gap-4 bg-yellow-50 p-5 rounded-2xl border border-yellow-100">
                    <div class="text-4xl">⭐</div>
                    <div>
                        <div class="text-3xl font-black text-gray-900">{{ $user->xp_total }} XP</div>
                        <div class="text-xs font-bold text-gray-500 uppercase tracking-wider">Niveau actuel : {{ strtoupper($user->niveau) }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- 2. VUE D'ENSEMBLE + FORMATIONS --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Barre de progression globale --}}
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-700 mb-4">Vue d'ensemble de votre formation</h3>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-500">Complétion globale</span>
                            <span class="text-xl font-black text-purple-600">{{ $progressionGlobale }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-5">
                            <div class="bg-gradient-to-r from-purple-500 to-indigo-500 h-5 rounded-full transition-all duration-1000" style="width: {{ $progressionGlobale }}%"></div>
                        </div>
                    </div>

                    {{-- Formations en cours --}}
                    <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-900">Vos formations en cours</h3>
                            <a href="{{ route('parcours.index') }}" class="text-sm font-semibold text-indigo-600 hover:underline">Voir le catalogue entier →</a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($parcoursEnCours as $p)
                                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200">
                                    <div class="mb-3">
                                        <span class="text-xs font-black text-green-600 uppercase tracking-wider">{{ $p->outil }}</span>
                                    </div>
                                    <h4 class="text-lg font-black text-gray-900 mb-4">{{ $p->titre }}</h4>
                                    <a href="{{ route('parcours.show', $p->id) }}" class="w-full inline-flex justify-center bg-white hover:bg-gray-100 text-gray-700 border border-gray-200 font-semibold py-2 px-4 rounded-xl transition text-sm">
                                        Reprendre la formation
                                    </a>
                                </div>
                            @empty
                                <div class="col-span-2 text-center py-8 text-gray-400">
                                    <p>Aucune formation en cours.</p>
                                    <a href="{{ route('parcours.index') }}" class="text-indigo-600 font-semibold hover:underline mt-2 inline-block">Voir le catalogue →</a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>

                {{-- 3. BADGES --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Vos Badges RH</h3>

                    @php
                        $badges = auth()->user()->badges()->withPivot('obtenu_at')->get();
                    @endphp

                    <div class="grid grid-cols-2 gap-4">
                        @forelse($badges as $badge)
                            <div class="flex flex-col items-center bg-yellow-50 border border-yellow-100 rounded-2xl p-4 text-center">
                                <x-badge-icon :type="$badge->condition_type" :unlocked="true" size="md" class="mb-2" />
                                <div class="font-black text-gray-900 text-sm">{{ $badge->titre }}</div>
                                <div class="text-xs text-yellow-600 font-semibold mt-1">Obtenu</div>
                            </div>
                        @empty
                            <div class="col-span-2 text-sm text-gray-400 text-center">Aucun badge encore obtenu.</div>
                        @endforelse
                    </div>

                    <p class="text-xs text-gray-400 text-center mt-6">Atteignez 100% dans un parcours pour débloquer sa certification officielle.</p>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>