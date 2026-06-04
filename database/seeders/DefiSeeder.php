<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Defi;

class DefiSeeder extends Seeder
{
    /**
     * Orchestrateur du contenu des formations.
     *
     * Chaque formation est un cursus professionnel complet (5 à 7 modules
     * progressifs) défini dans son propre seeder. On repart d'une base propre
     * pour éviter les doublons quand les titres de modules évoluent.
     */
    public function run(): void
    {
        // Réinitialise les modules (les progressions liées sont supprimées en cascade).
        Defi::query()->delete();

        $this->call([
            ExcelFormationSeeder::class,
            TeamsFormationSeeder::class,
            ErpFormationSeeder::class,
            EmailFormationSeeder::class,
        ]);
    }
}
