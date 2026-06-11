<?php

namespace Database\Seeders\Concerns;

use App\Models\Defi;
use App\Models\Parcours;

/**
 * Crée les modules d'une formation dans l'ordre du programme,
 * assigne automatiquement le champ `ordre` (Module 1, 2, 3…) et met à jour
 * le nombre total de modules de la formation.
 */
trait CreeModulesFormation
{
    protected function creerModules(Parcours $parcours, array $modules): void
    {
        foreach (array_values($modules) as $index => $module) {
            $module['parcours_id'] = $parcours->id;
            $module['ordre']       = $index + 1;
            Defi::create($module);
        }

        $parcours->update(['nb_defis_total' => count($modules)]);
    }
}
