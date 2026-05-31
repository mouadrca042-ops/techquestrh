<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="inline-block bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full mb-2 uppercase tracking-widest">Espace Administrateur</span>
                        <h2 class="text-3xl font-black text-gray-900">Panneau d'administration</h2>
                        <p class="text-gray-500 mt-1">Gérez le contenu de la plateforme TechQuest RH</p>
                    </div>
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('admin.parcours.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all">+ Nouveau parcours</a>
                        <a href="{{ route('admin.defis.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all">+ Nouveau défi</a>
                    </div>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                @php
                    $cards = [
                        ['label' => 'Employés', 'value' => $stats['total_employes'], 'color' => 'bg-blue-50 text-blue-700', 'icon' => '👤'],
                        ['label' => 'Managers', 'value' => $stats['total_managers'], 'color' => 'bg-purple-50 text-purple-700', 'icon' => '👔'],
                        ['label' => 'Parcours', 'value' => $stats['total_parcours'], 'color' => 'bg-indigo-50 text-indigo-700', 'icon' => '📚'],
                        ['label' => 'Défis', 'value' => $stats['total_defis'], 'color' => 'bg-green-50 text-green-700', 'icon' => '🎯'],
                        ['label' => 'Badges', 'value' => $stats['total_badges'], 'color' => 'bg-yellow-50 text-yellow-700', 'icon' => '🏅'],
                        ['label' => 'Complétés', 'value' => $stats['defis_completes'], 'color' => 'bg-emerald-50 text-emerald-700', 'icon' => '✅'],
                    ];
                @endphp
                @foreach($cards as $card)
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col items-center text-center shadow-sm">
                        <span class="text-2xl mb-2">{{ $card['icon'] }}</span>
                        <span class="text-3xl font-black text-gray-900">{{ $card['value'] }}</span>
                        <span class="text-xs text-gray-500 mt-1 font-medium">{{ $card['label'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- Nav modules --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $modules = [
                        ['title' => 'Parcours', 'desc' => 'Créer et gérer les parcours de formation', 'route' => 'admin.parcours', 'color' => 'border-indigo-400', 'bg' => 'bg-indigo-50', 'text' => 'text-indigo-700', 'icon' => '📚'],
                        ['title' => 'Défis', 'desc' => 'Gérer les QCM et questions Vrai/Faux', 'route' => 'admin.defis', 'color' => 'border-green-400', 'bg' => 'bg-green-50', 'text' => 'text-green-700', 'icon' => '🎯'],
                        ['title' => 'Badges', 'desc' => 'Configurer les récompenses et conditions', 'route' => 'admin.badges', 'color' => 'border-yellow-400', 'bg' => 'bg-yellow-50', 'text' => 'text-yellow-700', 'icon' => '🏅'],
                        ['title' => 'Utilisateurs', 'desc' => 'Gérer les rôles des utilisateurs', 'route' => 'admin.users', 'color' => 'border-purple-400', 'bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'icon' => '👥'],
                    ];
                @endphp
                @foreach($modules as $module)
                    <a href="{{ route($module['route']) }}" class="bg-white rounded-2xl border-2 {{ $module['color'] }} p-6 hover:shadow-md transition-all group">
                        <div class="{{ $module['bg'] }} w-12 h-12 rounded-xl flex items-center justify-center text-2xl mb-4">{{ $module['icon'] }}</div>
                        <h3 class="text-lg font-black text-gray-900 mb-1 group-hover:{{ $module['text'] }} transition-colors">{{ $module['title'] }}</h3>
                        <p class="text-sm text-gray-500">{{ $module['desc'] }}</p>
                    </a>
                @endforeach
            </div>

        </div>
    </div>
</x-app-layout>