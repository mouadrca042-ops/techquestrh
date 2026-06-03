<?php
<<<<<<< HEAD
namespace Database\Seeders;
=======

namespace Database\Seeders;

>>>>>>> 510ce3d9d6766b1930a6ad94d335fa3374d9fde3
use Illuminate\Database\Seeder;
use App\Models\Parcours;

class ParcoursSeeder extends Seeder
{
    public function run(): void
    {
<<<<<<< HEAD
        $parcours = [
            [
                'titre'          => 'Maîtriser Excel',
                'description'    => 'Apprenez à utiliser Excel facilement.',
                'outil'          => 'Excel',
                'nb_defis_total' => 4,
            ],
            [
                'titre'          => 'Utiliser Microsoft Teams',
                'description'    => 'Collaborez avec vos collègues via Teams.',
                'outil'          => 'Teams',
                'nb_defis_total' => 4,
            ],
            [
                'titre'          => 'Comprendre l\'ERP',
                'description'    => 'Initiez-vous aux outils ERP.',
                'outil'          => 'ERP',
                'nb_defis_total' => 4,
            ],
            [
                'titre'          => 'Email Professionnel',
                'description'    => 'Gérez vos emails professionnels.',
                'outil'          => 'Email',
                'nb_defis_total' => 4,
            ],
        ];

        foreach ($parcours as $p) {
            Parcours::create($p);
        }
=======
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
>>>>>>> 510ce3d9d6766b1930a6ad94d335fa3374d9fde3
    }
}