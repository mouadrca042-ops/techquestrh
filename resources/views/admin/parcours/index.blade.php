<x-app-layout>
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">

                <div class="flex items-center justify-between mb-6">
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-gray-600">← Admin</a>
                        <h2 class="text-2xl font-black text-gray-900 mt-1">Gestion des parcours</h2>
                    </div>
                    <a href="{{ route('admin.parcours.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all">+ Nouveau parcours</a>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">{{ session('success') }}</div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100">
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold">Titre</th>
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold">Outil</th>
                                <th class="text-left py-3 px-4 text-gray-500 font-semibold">Nb défis</th>
                                <th class="text-right py-3 px-4 text-gray-500 font-semibold">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($parcours as $p)
                                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4 font-semibold text-gray-800">{{ $p->titre }}</td>
                                    <td class="py-4 px-4">
                                        <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">{{ $p->outil }}</span>
                                    </td>
                                    <td class="py-4 px-4 text-gray-600">{{ $p->defis_count }} défi(s)</td>
                                    <td class="py-4 px-4 text-right flex justify-end gap-2">
                                        <a href="{{ route('admin.parcours.edit', $p) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">Modifier</a>
                                        <form action="{{ route('admin.parcours.destroy', $p) }}" method="POST" onsubmit="return confirm('Supprimer ce parcours ?')">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="py-10 text-center text-gray-400">Aucun parcours créé.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>