<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <a href="{{ route('admin.parcours') }}" class="text-sm text-gray-400 hover:text-gray-600">← Parcours</a>
                <h2 class="text-2xl font-black text-gray-900 mt-1 mb-6">Modifier le parcours</h2>

                <form action="{{ route('admin.parcours.update', $parcours) }}" method="POST" class="space-y-5">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre', $parcours->titre) }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Description</label>
                        <textarea name="description" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">{{ old('description', $parcours->description) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Outil *</label>
                        <select name="outil" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            @foreach(['Excel','Teams','ERP','Email'] as $o)
                                <option value="{{ $o }}" {{ old('outil', $parcours->outil) == $o ? 'selected' : '' }}>{{ $o }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold transition-all">Enregistrer</button>
                        <a href="{{ route('admin.parcours') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>