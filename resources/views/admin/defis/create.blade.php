<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <a href="{{ route('admin.defis') }}" class="text-sm text-gray-400 hover:text-gray-600">← Défis</a>
                <h2 class="text-2xl font-black text-gray-900 mt-1 mb-6">Nouveau défi</h2>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.defis.store') }}" method="POST" id="defiForm" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Parcours *</label>
                        <select name="parcours_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ old('parcours_id') == $p->id ? 'selected' : '' }}>{{ $p->titre }} ({{ $p->outil }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre du défi *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Type *</label>
                            <select name="type" id="typeSelect" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" onchange="toggleType()">
                                <option value="qcm" {{ old('type') == 'qcm' ? 'selected' : '' }}>QCM</option>
                                <option value="vrai_faux" {{ old('type') == 'vrai_faux' ? 'selected' : '' }}>Vrai / Faux</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Niveau *</label>
                            <select name="niveau" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400">
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">XP à gagner *</label>
                        <input type="number" name="xp_recompense" value="{{ old('xp_recompense', 10) }}" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Question *</label>
                        <textarea id="question" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Quelle est votre question ?"></textarea>
                    </div>

                    {{-- Section QCM --}}
                    <div id="sectionQcm" class="space-y-3 bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <p class="text-sm font-bold text-gray-700 mb-2">Options (4 choix) + bonne réponse</p>
                        @for($i = 1; $i <= 4; $i++)
                            <div class="flex items-center gap-3">
                                <input type="text" id="option{{ $i }}" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm" placeholder="Option {{ $i }}">
                                <label class="flex items-center gap-1 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="bonne_reponse_qcm" value="{{ $i }}" {{ $i == 1 ? 'checked' : '' }}> Bonne réponse
                                </label>
                            </div>
                        @endfor
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1 mt-3">Explication après réponse</label>
                            <textarea id="explicationQcm" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm" placeholder="Explication affichée après la réponse..."></textarea>
                        </div>
                    </div>

                    {{-- Section Vrai/Faux --}}
                    <div id="sectionVraiFaux" class="hidden space-y-3 bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <p class="text-sm font-bold text-gray-700 mb-2">Bonne réponse</p>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bonne_reponse_vf" value="Vrai" checked> <span class="text-sm font-semibold text-green-700">Vrai</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bonne_reponse_vf" value="Faux"> <span class="text-sm font-semibold text-red-700">Faux</span>
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1 mt-3">Explication après réponse *</label>
                            <textarea id="explicationVf" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm" placeholder="Explication affichée après la réponse..."></textarea>
                        </div>
                    </div>

                    {{-- Champ caché contenu_json --}}
                    <input type="hidden" name="contenu_json" id="contenuJson">

                    <div class="flex gap-3 pt-2">
                        <button type="submit" onclick="buildJson()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition-all">Créer le défi</button>
                        <a href="{{ route('admin.defis') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleType() {
            const type = document.getElementById('typeSelect').value;
            document.getElementById('sectionQcm').classList.toggle('hidden', type !== 'qcm');
            document.getElementById('sectionVraiFaux').classList.toggle('hidden', type !== 'vrai_faux');
        }

        function buildJson() {
            const type = document.getElementById('typeSelect').value;
            const question = document.getElementById('question').value;
            let contenu = { question };

            if (type === 'qcm') {
                const options = [
                    document.getElementById('option1').value,
                    document.getElementById('option2').value,
                    document.getElementById('option3').value,
                    document.getElementById('option4').value,
                ];
                const bonneReponseIndex = parseInt(document.querySelector('input[name="bonne_reponse_qcm"]:checked').value) - 1;
                contenu.options = options;
                contenu.bonne_reponse = options[bonneReponseIndex];
                contenu.explication = document.getElementById('explicationQcm').value;
            } else {
                contenu.bonne_reponse = document.querySelector('input[name="bonne_reponse_vf"]:checked').value;
                contenu.explication = document.getElementById('explicationVf').value;
            }

            document.getElementById('contenuJson').value = JSON.stringify(contenu);
        }

        toggleType();
    </script>
</x-app-layout>