<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;

class ParcoursSeeder extends Seeder
{
    public function run(): void
    {
        // On crée les parcours de base du CDC
        Parcours::create([
            'titre' => 'Maîtriser Microsoft Teams',
            'description' => 'Apprenez à communiquer, partager des fichiers et organiser des réunions facilement avec vos collègues.',
            'outil' => 'Teams',
            'nb_defis_total' => 3
        ]);

        Parcours::create([
            'titre' => 'Les Fondamentaux d\'Excel',
            'description' => 'Maîtrisez les tableaux, les calculs simples et la mise en forme pour gagner du temps au quotidien.',
            'outil' => 'Excel',
            'nb_defis_total' => 5
        ]);
        
        Parcours::create([
            'titre' => 'Utiliser l\'ERP de l\'entreprise',
            'description' => 'Découvrez comment gérer vos demandes de congés et consulter vos fiches de paie en toute autonomie.',
            'outil' => 'ERP',
            'nb_defis_total' => 4
        ]);
    }
}