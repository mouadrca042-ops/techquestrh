<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <a href="{{ route('admin.defis') }}" class="text-sm text-gray-400 hover:text-gray-600">← Défis</a>
                <h2 class="text-2xl font-black text-gray-900 mt-1 mb-6">Nouveau défi</h2>

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        <ul class="list-disc list-inside">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <form action="{{ route('admin.defis.store') }}" method="POST" id="defiForm" class="space-y-6">
                    @csrf

                    {{-- ── Infos générales ───────────────────────── --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Parcours *</label>
                        <select name="parcours_id" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}" {{ old('parcours_id') == $p->id ? 'selected' : '' }}>{{ $p->titre }} ({{ $p->outil }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Titre du module *</label>
                        <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Objectif (résumé affiché en haut du module)</label>
                        <input type="text" name="objectif" value="{{ old('objectif') }}" placeholder="Ex : Maîtriser les formules de base" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Type *</label>
                            <select name="type" id="typeSelect" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" onchange="toggleType()">
                                <option value="qcm">QCM</option>
                                <option value="vrai_faux">Vrai / Faux</option>
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
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">XP *</label>
                            <input type="number" name="xp_recompense" value="{{ old('xp_recompense', 10) }}" min="1" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Durée estimée de la leçon</label>
                        <input type="text" name="duree" value="{{ old('duree', '2 min') }}" placeholder="Ex : 2 min" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400">
                    </div>

                    {{-- ── Sections de la leçon ──────────────────── --}}
                    <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200" id="sectionsContainer">
                        <div class="flex items-center justify-between mb-3">
                            <p class="text-sm font-bold text-gray-700">📖 Contenu de la leçon (sections)</p>
                            <button type="button" onclick="ajouterSection()" class="text-xs font-semibold text-blue-600 hover:underline">+ Ajouter une section</button>
                        </div>

                        <div class="space-y-3" id="sectionsList">
                            <div class="section-item bg-white p-3 rounded-xl border border-gray-200 space-y-2">
                                <input type="text" name="sections[0][titre]" placeholder="Titre de la section" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>
                                <textarea name="sections[0][corps]" rows="2" placeholder="Contenu / explication de la section" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ── Question du quiz ──────────────────────── --}}
                    <div class="space-y-3">
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Question du quiz *</label>
                        <textarea name="question" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Quelle est votre question ?" required>{{ old('question') }}</textarea>
                    </div>

                    {{-- Section QCM --}}
                    <div id="sectionQcm" class="space-y-3 bg-gray-50 rounded-2xl p-5 border border-gray-200">
                        <p class="text-sm font-bold text-gray-700 mb-2">Options (jusqu'à 4) + bonne réponse</p>
                        @for($i = 0; $i < 4; $i++)
                            <div class="flex items-center gap-3">
                                <input type="text" name="options[]" class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm" placeholder="Option {{ $i + 1 }}">
                                <label class="flex items-center gap-1 text-sm text-gray-600 cursor-pointer whitespace-nowrap">
                                    <input type="radio" name="bonne_reponse" value="{{ $i }}" {{ $i == 0 ? 'checked' : '' }}> Bonne réponse
                                </label>
                            </div>
                        @endfor
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
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Explication après réponse</label>
                        <textarea name="explication" rows="2" class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Explication affichée après la réponse...">{{ old('explication') }}</textarea>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="submit" onclick="prepareSubmit()" class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-xl font-bold transition-all">Créer le défi</button>
                        <a href="{{ route('admin.defis') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-xl font-semibold transition-all">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let sectionIndex = 1;

        function ajouterSection() {
            const div = document.createElement('div');
            div.className = 'section-item bg-white p-3 rounded-xl border border-gray-200 space-y-2';
            div.innerHTML = `
                <div class="flex justify-between items-center gap-2">
                    <input type="text" name="sections[${sectionIndex}][titre]" placeholder="Titre de la section" class="flex-1 border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400" required>
                    <button type="button" onclick="this.closest('.section-item').remove()" class="text-red-500 hover:text-red-700 text-sm">✕</button>
                </div>
                <textarea name="sections[${sectionIndex}][corps]" rows="2" placeholder="Contenu / explication de la section" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
            `;
            document.getElementById('sectionsList').appendChild(div);
            sectionIndex++;
        }

        function toggleType() {
            const type = document.getElementById('typeSelect').value;
            document.getElementById('sectionQcm').classList.toggle('hidden', type !== 'qcm');
            document.getElementById('sectionVraiFaux').classList.toggle('hidden', type !== 'vrai_faux');
        }

        function prepareSubmit() {
            const type = document.getElementById('typeSelect').value;
            if (type === 'vrai_faux') {
                const vf = document.querySelector('input[name="bonne_reponse_vf"]:checked').value;
                let hidden = document.querySelector('input[name="bonne_reponse"][type="hidden"]');
                if (!hidden) {
                    hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'bonne_reponse';
                    document.getElementById('defiForm').appendChild(hidden);
                }
                hidden.value = vf;
                document.querySelectorAll('#sectionQcm input[name="bonne_reponse"]').forEach(el => el.disabled = true);
            }
        }

        toggleType();
    </script>
</x-app-layout>