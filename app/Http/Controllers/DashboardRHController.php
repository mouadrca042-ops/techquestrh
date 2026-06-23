<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parcours;
use App\Models\Defi;
use App\Models\Badge;
use App\Models\Progression;
use Carbon\Carbon;

class DashboardRHController extends Controller
{
    /**
     * Tableau de bord RH (Module 4 du CDC).
     * Couvre F24 (accès distinct), F25 (vue globale), F26 (liste employés),
     * F27 (graphique 8 semaines), F28 (employés en difficulté).
     */
    public function index()
    {
        return view('dashboard-rh', $this->preparerDonnees());
    }

    /**
     * F29 : Export du rapport de progression en PDF.
     * On renvoie une vue imprimable que le navigateur convertit en PDF
     * (aucune librairie externe requise).
     */
    public function exportPDF()
    {
        return view('dashboard-rh-print', $this->preparerDonnees());
    }

    /**
     * Centralise tous les calculs partagés par le dashboard et l'export.
     */
    private function preparerDonnees(): array
    {
        $parcours = Parcours::all();

        // Employés (avec nb de badges + parcours suivis), c'est le public cible du suivi RH
        $employes = User::where('role', 'employe')
            ->withCount('badges')
            ->with('parcours')
            ->orderByDesc('xp_total')
            ->get();

        // On calcule la progression globale de chaque employé (défis complétés / total des défis)
        $totalDefis = Defi::count();
        foreach ($employes as $emp) {
            $defisCompletes = $emp->progressions()->whereNotNull('completed_at')->count();
            $emp->progression_globale = $totalDefis > 0
                ? (int) round(($defisCompletes / $totalDefis) * 100)
                : 0;
        }

        // ── F25 : indicateurs globaux ─────────────────────────────────────────
        $totalEmployes  = $employes->count();
        $totalManagers  = User::where('role', 'manager')->count();
        $totalParcours  = $parcours->count();
        $totalBadges    = Badge::count();
        $defisCompletesTotal = Progression::whereNotNull('completed_at')->count();
        $xpMoyen        = (int) round($employes->avg('xp_total') ?? 0);

        $tauxCompletion = ($totalEmployes > 0 && $totalDefis > 0)
            ? round(($defisCompletesTotal / ($totalEmployes * $totalDefis)) * 100, 1)
            : 0;

        $stats = [
            'total_employes'  => $totalEmployes,
            'total_managers'  => $totalManagers,
            'total_parcours'  => $totalParcours,
            'total_defis'     => $totalDefis,
            'total_badges'    => $totalBadges,
            'defis_completes' => $defisCompletesTotal,
            'xp_moyen'        => $xpMoyen,
            'taux_completion' => $tauxCompletion,
        ];

        // ── F28 : employés en difficulté (progression < 20 %) ─────────────────
        $employesEnDifficulte = $employes->filter(fn($e) => $e->progression_globale < 20)->values();

        // ── F27 : progression globale de l'équipe sur les 8 dernières semaines ─
        $denominateur = max(1, $totalEmployes * $totalDefis);
        $chartLabels  = [];
        $chartData    = [];
        for ($i = 7; $i >= 0; $i--) {
            $finSemaine = Carbon::now()->subWeeks($i)->endOfWeek();
            $cumul = Progression::whereNotNull('completed_at')
                ->where('completed_at', '<=', $finSemaine)
                ->count();
            $chartLabels[] = 'Sem. ' . (8 - $i);
            $chartData[]   = round(($cumul / $denominateur) * 100, 1);
        }

        return [
            'employes'             => $employes,
            'parcours'             => $parcours,
            'stats'                => $stats,
            'employesEnDifficulte' => $employesEnDifficulte,
            'chartLabels'          => $chartLabels,
            'chartData'            => $chartData,
            'genereLe'             => Carbon::now()->format('d/m/Y à H:i'),
        ];
    }
}
