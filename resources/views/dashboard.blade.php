<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-blue-800 leading-tight">
            {{ __('Mon Espace Apprentissage') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-10">
                
                <!-- En-tête Profil -->
                <div class="flex items-center space-x-6 mb-10 border-b pb-6">
                    <div class="h-20 w-20 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Bonjour, {{ Auth::user()->name }} !</h1>
                        <p class="text-xl text-gray-500 italic">Poste : {{ Auth::user()->poste ?? 'En cours de définition' }}</p>
                    </div>
                </div>

                <!-- Grille de Progression (Objectif S2) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Carte Niveau -->
                    <div class="bg-blue-50 p-8 rounded-2xl border-2 border-blue-200 text-center">
                        <p class="text-blue-600 text-xl font-semibold uppercase">Votre Niveau</p>
                        <p class="text-6xl font-black text-blue-900 mt-2">{{ Auth::user()->niveau }}</p>
                    </div>

                    <!-- Carte XP -->
                    <div class="bg-green-50 p-8 rounded-2xl border-2 border-green-200 text-center">
                        <p class="text-green-600 text-xl font-semibold uppercase">Points d'Expérience</p>
                        <p class="text-6xl font-black text-green-900 mt-2">{{ Auth::user()->xp_total }} XP</p>
                    </div>
                </div>

                <!-- Message d'encouragement -->
                <div class="mt-12 p-6 bg-yellow-50 rounded-xl border border-yellow-100 text-center">
                    <p class="text-2xl text-yellow-800 font-medium">"Excellent travail. Continuez ainsi !"</p>
                </div>
                <!-- Section : Choix du Parcours (Objectif S3) -->
            <div class="mt-16">
                <h3 class="text-3xl font-bold text-gray-800 mb-8 border-b-2 border-blue-200 pb-2">Nos parcours de formation</h3>

                <!-- Grille des parcours générée dynamiquement -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($parcours as $p)
                
<div class="bg-white p-8 rounded-2xl border-2 border-gray-100 shadow-sm hover:shadow-lg hover:border-blue-300 transition duration-300 flex flex-col justify-between">
    
    <div>
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-2xl font-bold text-blue-900">{{ $p->titre }}</h4>
            <span class="bg-blue-100 text-blue-800 text-sm font-bold px-4 py-2 rounded-full uppercase">{{ $p->outil }}</span>
        </div>
        <p class="text-gray-600 text-lg mb-8 min-h-[60px]">{{ $p->description }}</p>
    </div>
    
    <div>
        <!-- NOUVEAU : Barre de progression (Objectif S3) -->
        <div class="mb-6">
            <div class="flex justify-between text-sm font-bold text-gray-500 mb-2">
                <span>Progression</span>
                <span>0 / {{ $p->nb_defis_total }} défis</span>
            </div>
            <!-- Fond de la barre (gris) -->
            <div class="w-full bg-gray-200 rounded-full h-3">
                <!-- Remplissage de la barre (vert), forcé à 0% pour le moment -->
                <div class="bg-green-500 h-3 rounded-full" style="width: 0%;"></div>
            </div>
        </div>

        <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-4 rounded-xl transition text-xl shadow-md">
            Choisir ce parcours
       </button>
    </div> 

 </div> 


@endforeach
</div>
                </div>
            </div>

            </div>
        </div>
    </div>
</x-app-layout>