<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ── En-tête RH (distinct de l'admin : violet) ───────────────────── --}}
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="inline-block bg-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full mb-2 uppercase tracking-widest">Espace Manager RH</span>
                        <h2 class="text-3xl font-black text-gray-900">Tableau de bord RH</h2>
                        <p class="text-gray-500 mt-1">Suivi de la progression et de la montée en compétences de vos collaborateurs</p>
                    </div>
                    <div class="hidden md:flex items-center gap-3">
                        <a href="{{ route('dashboard.export') }}" target="_blank" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all inline-flex items-center gap-2"><x-icon name="document" class="w-4 h-4" /> Exporter en PDF</a>
                    </div>
                </div>
            </div>

            {{-- ── F25 : indicateurs globaux ───────────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-6">
                @php
                    $cards = [
                        ['label' => 'Employés',        'value' => $stats['total_employes'],          'icon' => 'user',        'color' => 'text-blue-600'],
                        ['label' => 'XP Moyen',        'value' => $stats['xp_moyen'] . ' XP',        'icon' => 'bolt',        'color' => 'text-amber-500'],
                        ['label' => 'Taux complétion', 'value' => $stats['taux_completion'] . ' %',  'icon' => 'trending-up', 'color' => 'text-emerald-600'],
                        ['label' => 'Parcours',        'value' => $stats['total_parcours'],          'icon' => 'academic',    'color' => 'text-indigo-600'],
                        ['label' => 'Défis',           'value' => $stats['total_defis'],             'icon' => 'target',      'color' => 'text-green-600'],
                        ['label' => 'Badges',          'value' => $stats['total_badges'],            'icon' => 'medal',       'color' => 'text-yellow-500'],
                    ];
                @endphp
                @foreach($cards as $card)
                    <div class="bg-white rounded-2xl border border-gray-100 p-5 flex flex-col items-center text-center shadow-sm">
                        <x-icon :name="$card['icon']" class="w-8 h-8 mb-2 {{ $card['color'] }}" />
                        <span class="text-3xl font-black text-gray-900">{{ $card['value'] }}</span>
                        <span class="text-xs text-gray-500 mt-1 font-medium">{{ $card['label'] }}</span>
                    </div>
                @endforeach
            </div>

            {{-- ── F27 : graphique de progression de l'équipe sur 8 semaines ───── --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-1 flex items-center gap-2"><x-icon name="chart-bar" class="w-5 h-5 text-purple-600" /> Progression globale de l'équipe</h3>
                <p class="text-xs text-gray-500 mb-4">Taux de complétion cumulé de l'équipe sur les 8 dernières semaines</p>
                <canvas id="progressionChart" height="90"></canvas>
            </div>

            {{-- ── F28 : alerte employés en difficulté ─────────────────────────── --}}
            <div class="bg-red-50/60 rounded-2xl border border-red-100 p-6 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <x-icon name="alert" class="w-7 h-7 text-red-500 shrink-0" />
                    <div>
                        <h3 class="text-lg font-bold text-red-950">Accompagnement (progression faible)</h3>
                        <p class="text-xs text-red-700/80">Collaborateurs ayant moins de 20 % de progression, à suivre avec bienveillance (Exigence F28).</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($employesEnDifficulte as $emp)
                        <div class="bg-white rounded-xl p-4 border border-red-100 shadow-sm flex justify-between items-center">
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $emp->name }}</h4>
                                <p class="text-xs text-gray-500">{{ $emp->poste ?? 'Employé senior' }}</p>
                            </div>
                            <span class="text-xs bg-red-50 text-red-700 font-black px-2.5 py-1 rounded-full">{{ $emp->progression_globale }} %</span>
                        </div>
                    @empty
                        <div class="col-span-full bg-white/80 rounded-xl p-4 text-center border border-gray-100 text-sm text-green-700 italic">
                            ✨ Tous les collaborateurs affichent une dynamique de progression positive.
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- ── F26 : liste des employés (triable + filtrable) ──────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-5">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2"><x-icon name="users" class="w-5 h-5 text-purple-600" /> Progression des collaborateurs</h3>
                    <div class="flex flex-wrap gap-2">
                        <input id="filtreNom" type="text" placeholder="🔍 Rechercher un nom…"
                               class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                        <select id="filtreNiveau" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Tous les niveaux</option>
                            <option value="debutant">Débutant</option>
                            <option value="intermediaire">Intermédiaire</option>
                            <option value="expert">Expert</option>
                        </select>
                        <select id="filtreParcours" class="border border-gray-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-400">
                            <option value="">Tous les parcours</option>
                            @foreach($parcours as $p)
                                <option value="{{ $p->id }}">{{ $p->titre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @php
                    $niveauStyles = [
                        'debutant'      => ['Débutant', 'bg-gray-100 text-gray-700'],
                        'intermediaire' => ['Intermédiaire', 'bg-blue-100 text-blue-700'],
                        'expert'        => ['Expert', 'bg-purple-100 text-purple-700'],
                    ];
                @endphp

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" id="tableEmployes">
                        <thead>
                            <tr class="text-left text-xs text-gray-500 uppercase border-b border-gray-100">
                                <th class="px-4 py-3">Collaborateur</th>
                                <th class="px-4 py-3">Niveau</th>
                                <th class="px-4 py-3 cursor-pointer select-none" data-sort="xp">XP Total ⇅</th>
                                <th class="px-4 py-3 cursor-pointer select-none" data-sort="prog">Progression ⇅</th>
                                <th class="px-4 py-3">Badges</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="corpsEmployes">
                            @forelse($employes as $emp)
                                @php $niv = $niveauStyles[$emp->niveau] ?? ['—', 'bg-gray-100 text-gray-700']; @endphp
                                <tr class="ligne-employe hover:bg-gray-50 transition-colors"
                                    data-nom="{{ strtolower($emp->name) }}"
                                    data-niveau="{{ $emp->niveau }}"
                                    data-parcours="{{ $emp->parcours->pluck('id')->implode(',') }}"
                                    data-xp="{{ $emp->xp_total }}"
                                    data-prog="{{ $emp->progression_globale }}">
                                    <td class="px-4 py-3">
                                        <div class="font-bold text-gray-900">{{ $emp->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $emp->poste ?? 'Employé senior' }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $niv[1] }}">{{ $niv[0] }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-bold text-purple-600">{{ $emp->xp_total }} XP</td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-24 bg-gray-100 rounded-full h-2 overflow-hidden">
                                                <div class="h-2 rounded-full bg-gradient-to-r from-purple-500 to-indigo-500" style="width: {{ $emp->progression_globale }}%"></div>
                                            </div>
                                            <span class="text-xs font-semibold text-gray-600">{{ $emp->progression_globale }} %</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1 font-semibold text-gray-700">{{ $emp->badges_count }} <x-icon name="medal" class="w-4 h-4 text-yellow-500" /></span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400">Aucun collaborateur enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <p id="aucunResultat" class="hidden text-center text-gray-400 text-sm py-6">Aucun collaborateur ne correspond à ces filtres.</p>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js (F27) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ── Graphique de progression (F27) ──
            const ctx = document.getElementById('progressionChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            label: 'Taux de complétion de l\'équipe (%)',
                            data: @json($chartData),
                            borderColor: '#7c3aed',
                            backgroundColor: 'rgba(124, 58, 237, 0.1)',
                            fill: true,
                            tension: 0.35,
                            pointBackgroundColor: '#7c3aed',
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: { y: { beginAtZero: true, max: 100, ticks: { callback: v => v + ' %' } } },
                        plugins: { legend: { display: false } }
                    }
                });
            }

            // ── Filtres + tri du tableau (F26) ──
            const corps    = document.getElementById('corpsEmployes');
            const lignes   = Array.from(document.querySelectorAll('.ligne-employe'));
            const fNom     = document.getElementById('filtreNom');
            const fNiveau  = document.getElementById('filtreNiveau');
            const fParc    = document.getElementById('filtreParcours');
            const vide     = document.getElementById('aucunResultat');

            function filtrer() {
                const nom = fNom.value.trim().toLowerCase();
                const niv = fNiveau.value;
                const par = fParc.value;
                let visibles = 0;
                lignes.forEach(l => {
                    const okNom = !nom || l.dataset.nom.includes(nom);
                    const okNiv = !niv || l.dataset.niveau === niv;
                    const okPar = !par || (l.dataset.parcours || '').split(',').includes(par);
                    const show = okNom && okNiv && okPar;
                    l.style.display = show ? '' : 'none';
                    if (show) visibles++;
                });
                vide.classList.toggle('hidden', visibles !== 0);
            }
            [fNom, fNiveau, fParc].forEach(el => el.addEventListener('input', filtrer));

            // Tri par colonne (XP / progression)
            let sensAsc = {};
            document.querySelectorAll('[data-sort]').forEach(th => {
                th.addEventListener('click', () => {
                    const cle = th.dataset.sort;
                    sensAsc[cle] = !sensAsc[cle];
                    const tri = sensAsc[cle] ? 1 : -1;
                    lignes.sort((a, b) => (Number(a.dataset[cle]) - Number(b.dataset[cle])) * tri)
                          .forEach(l => corps.appendChild(l));
                });
            });
        });
    </script>
</x-app-layout>
