{{-- create.blade.php --}}
<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <a href="{{ route('admin.badges') }}" class="text-sm text-gray-400 hover:text-gray-600">← Badges</a>
                <h2 class="text-2xl font-black text-gray-900 mt-1 mb-6">Nouveau badge</h2>

                <form action="{{ route('admin.badges.store') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Description *</label>
                        <textarea name="description" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>{{ old('description') }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Condition *</label>
                            <select name="condition_type" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400">
                                @foreach(['premier_defi','assidu','maitrise','explorateur','secret'] as $c)
                                    <option value="{{ $c }}" {{ old('condition_type') == $c ? 'selected' : '' }}>{{ $c }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Valeur *</label>
                            <input type="number" name="condition_valeur" value="{{ old('condition_valeur', 1) }}" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" required>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Emoji / icône</label>
                        <input type="text" name="image" value="{{ old('image', '🏅') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400" placeholder="🏅">
                    </div>
                    <div class="flex gap-3 pt-2">
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-3 rounded-xl font-bold transition-all">Créer le badge</button>
                        <a href="{{ route('admin.badges') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>