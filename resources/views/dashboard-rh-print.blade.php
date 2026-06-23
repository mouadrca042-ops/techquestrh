<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport RH - TechQuest</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Arial, sans-serif; color: #1f2937; margin: 32px; font-size: 13px; }
        h1 { font-size: 22px; margin: 0; }
        .sub { color: #6b7280; margin: 4px 0 20px; font-size: 12px; }
        .cards { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 24px; }
        .card { flex: 1 1 140px; border: 1px solid #e5e7eb; border-radius: 12px; padding: 14px; text-align: center; }
        .card .val { font-size: 22px; font-weight: 800; }
        .card .lab { font-size: 11px; color: #6b7280; text-transform: uppercase; }
        h2 { font-size: 15px; margin: 24px 0 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 8px 10px; border-bottom: 1px solid #e5e7eb; }
        th { font-size: 11px; text-transform: uppercase; color: #6b7280; }
        .pill { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 999px; background: #f3e8ff; color: #7c3aed; }
        .alert { color: #b91c1c; }
        .btn { background: #7c3aed; color: #fff; border: none; padding: 10px 18px; border-radius: 10px; font-size: 13px; cursor: pointer; }
        @media print { .no-print { display: none; } body { margin: 12px; } }
    </style>
</head>
<body>
    <button class="btn no-print" onclick="window.print()">📄 Télécharger / Imprimer en PDF</button>

    <div style="margin-top:16px">
        <h1>Rapport de progression de l'équipe</h1>
        <p class="sub">TechQuest RH — généré le {{ $genereLe }}</p>
    </div>

    {{-- Indicateurs globaux (F25) --}}
    <div class="cards">
        <div class="card"><div class="val">{{ $stats['total_employes'] }}</div><div class="lab">Employés</div></div>
        <div class="card"><div class="val">{{ $stats['xp_moyen'] }} XP</div><div class="lab">XP Moyen</div></div>
        <div class="card"><div class="val">{{ $stats['taux_completion'] }} %</div><div class="lab">Taux complétion</div></div>
        <div class="card"><div class="val">{{ $stats['total_parcours'] }}</div><div class="lab">Parcours</div></div>
        <div class="card"><div class="val">{{ $stats['defis_completes'] }}</div><div class="lab">Défis complétés</div></div>
    </div>

    {{-- Liste des collaborateurs (F26) --}}
    <h2>Progression des collaborateurs</h2>
    <table>
        <thead>
            <tr>
                <th>Collaborateur</th><th>Poste</th><th>Niveau</th><th>XP Total</th><th>Progression</th><th>Badges</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employes as $emp)
                <tr>
                    <td><strong>{{ $emp->name }}</strong></td>
                    <td>{{ $emp->poste ?? 'Employé senior' }}</td>
                    <td><span class="pill">{{ ucfirst($emp->niveau) }}</span></td>
                    <td>{{ $emp->xp_total }} XP</td>
                    <td @if($emp->progression_globale < 20) class="alert" @endif>{{ $emp->progression_globale }} %</td>
                    <td>{{ $emp->badges_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Employés en difficulté (F28) --}}
    @if($employesEnDifficulte->count() > 0)
        <h2 class="alert">⚠️ Collaborateurs à accompagner (&lt; 20 %)</h2>
        <table>
            <thead><tr><th>Nom</th><th>Poste</th><th>Progression</th></tr></thead>
            <tbody>
                @foreach($employesEnDifficulte as $emp)
                    <tr><td>{{ $emp->name }}</td><td>{{ $emp->poste ?? 'Employé senior' }}</td><td class="alert">{{ $emp->progression_globale }} %</td></tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <script>window.addEventListener('load', () => setTimeout(() => window.print(), 400));</script>
</body>
</html>
