<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-gray-600">← Admin</a>
                        <h2 class="text-2xl font-black text-gray-900 mt-1">Gestion des badges</h2>
                    </div>
                    <a href="{{ route('admin.badges.create') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all">+ Nouveau badge</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($badges as $badge)
                        <div class="border border-gray-100 rounded-2xl p-5 hover:shadow-sm transition-all">
                            <div class="flex items-start justify-between mb-3">
                                <div class="text-3xl">{{ $badge->image ?? '🏅' }}</div>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full font-semibold">{{ $badge->users_count }} utilisateur(s)</span>
                            </div>
                            <h3 class="font-black text-gray-900 text-lg">{{ $badge->titre }}</h3>
                            <p class="text-sm text-gray-500 mt-1 mb-3">{{ $badge->description }}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full font-semibold">{{ $badge->condition_type }} · {{ $badge->condition_valeur }}</span>
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.badges.edit', $badge) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">Modifier</a>
                                    <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST" onsubmit="return confirm('Supprimer ce badge ?')">
                                        @csrf @method('DELETE')
                                        <button class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 py-10 text-center text-gray-400">Aucun badge créé.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>