<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                @php $contenu = json_decode($defi->contenu_json, true); @endphp
                <a href="{{ route('admin.defis') }}" class="text-sm text-gray-400 hover:text-gray-600">← Défis</a>
                <h2 class="text-2xl font-black text-gray-900 mt-1 mb-6">Modifier le défi</h2>

                <form action="{{ route('admin.defis.update', $defi) }}" method="POST" id="defiForm" class="space-y-5">
                    @csrf @method('PUT')

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Parcours *</label>
                        <select name="parcours_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ $defi->parcours_id == $p->id ? 'selected' : '' }}>{{ $p->titre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre *</label>
                        <input type="text" name="titre" value="{{ $defi->titre }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Type *</label>
                            <select name="type" id="typeSelect" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" onchange="toggleType()">
                                <option value="qcm" {{ $defi->type == 'qcm' ? 'selected' : '' }}>QCM</option>
                                <option value="vrai_faux" {{ $defi->type == 'vrai_faux' ? 'selected' : '' }}>Vrai / Faux</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Niveau *</label>
                            <select name="niveau" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400">
                                @foreach(['debutant','intermediaire','expert'] as $n)
                                    <option value="{{ $n }}" {{ $defi->niveau == $n ? 'selected' : '' }}>{{ ucfirst($n) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">XP *</label>
                        <input type="number" name="xp_recompense" value="{{ $defi->xp_recompense }}" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Question *</label>
                        <textarea id="question" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400">{{ $contenu['question'] ?? '' }}</textarea>
                    </div>

                    <div id="sectionQcm" class="space-y-3 bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <p class="text-sm font-bold text-gray-700 mb-2">Options QCM</p>
                        @for($i = 1; $i <= 4; $i++)
                            @php $optionVal = $contenu['options'][$i-1] ?? ''; $isBonne = ($optionVal === ($contenu['bonne_reponse'] ?? '')); @endphp
                            <div class="flex items-center gap-3">
                                <input type="text" id="option{{ $i }}" value="{{ $optionVal }}" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm" placeholder="Option {{ $i }}">
                                <label class="flex items-center gap-1 text-sm text-gray-600 cursor-pointer">
                                    <input type="radio" name="bonne_reponse_qcm" value="{{ $i }}" {{ $isBonne ? 'checked' : '' }}> Bonne réponse
                                </label>
                            </div>
                        @endfor
                        <textarea id="explicationQcm" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm mt-2" placeholder="Explication...">{{ $contenu['explication'] ?? '' }}</textarea>
                    </div>

                    <div id="sectionVraiFaux" class="hidden space-y-3 bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <p class="text-sm font-bold text-gray-700 mb-2">Bonne réponse</p>
                        <div class="flex gap-6">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bonne_reponse_vf" value="Vrai" {{ ($contenu['bonne_reponse'] ?? '') == 'Vrai' ? 'checked' : '' }}> <span class="text-sm font-semibold text-green-700">Vrai</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="bonne_reponse_vf" value="Faux" {{ ($contenu['bonne_reponse'] ?? '') == 'Faux' ? 'checked' : '' }}> <span class="text-sm font-semibold text-red-700">Faux</span>
                            </label>
                        </div>
                        <textarea id="explicationVf" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm mt-2" placeholder="Explication...">{{ $contenu['explication'] ?? '' }}</textarea>
                    </div>

                    <input type="hidden" name="contenu_json" id="contenuJson">

                    <div class="flex gap-3 pt-2">
                        <button type="submit" onclick="buildJson()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition-all">Enregistrer</button>
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
                const options = ['option1','option2','option3','option4'].map(id => document.getElementById(id).value);
                const idx = parseInt(document.querySelector('input[name="bonne_reponse_qcm"]:checked').value) - 1;
                contenu.options = options;
                contenu.bonne_reponse = options[idx];
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