<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       \App\Models\User::create([
          'name' => 'Ali Senior',
          'email' => 'ali@gmail.com',
          'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
          'role' => 'admin',
       ]); 

         // 1. Création des Parcours
      $excel = \App\Models\Parcours::create([
        'titre' => 'Les Fondamentaux d\'Excel',
        'description' => 'Maîtrisez les tableaux et les calculs simples.',
        'outil' => 'Excel', // Remplace 'image' par 'outil'
        'nb_defis_total' => 3
      ]);

      $teams = \App\Models\Parcours::create([
        'titre' => 'Maîtriser Microsoft Teams',
        'description' => 'Apprenez à communiquer et organiser des réunions.',
        'outil' => 'Teams',
        'nb_defis_total' => 2
      ]);

        // 2. Ajout de défis pour EXCEL
      $excel->defis()->createMany([
      [
        'titre' => 'Ma première formule',
        'type' => 'qcm',
        'niveau' => 1,
        'xp_recompense' => 50,
        'contenu_json' => json_encode([
            'question' => 'Quelle fonction permet de faire une somme ?',
            'options' => ['=SOMME()', '=TOTAL()', '=ADD()'],
            'reponse' => '=SOMME()'
        ])
      ],
      [
        'titre' => 'Mise en forme',
        'type' => 'vrai_faux',
        'niveau' => 2,
        'xp_recompense' => 100,
        'contenu_json' => json_encode([
            'question' => 'Peut-on mettre une cellule en rouge sous condition ?',
            'reponse' => true
        ])
      ],
      [
        'titre' => 'Les Graphiques',
        'type' => 'qcm',
        'niveau' => 3,
        'xp_recompense' => 150,
        'contenu_json' => json_encode([
            'question' => 'Quel graphique est idéal pour une répartition en % ?',
            'options' => ['Histogramme', 'Secteurs (Camembert)', 'Courbe'],
            'reponse' => 'Secteurs (Camembert)'
        ])
      ]
      ]);

       // 3. Ajout de défis pour TEAMS
      $teams->defis()->createMany([
      [
        'titre' => 'Rejoindre un canal',
        'type' => 'vrai_faux',
        'niveau' => 1,
        'xp_recompense' => 30,
        'contenu_json' => json_encode([
            'question' => 'Un canal peut-être privé ?',
            'reponse' => true
        ])
      ],
      [
        'titre' => 'Planifier un call',
        'type' => 'qcm',
        'niveau' => 2,
        'xp_recompense' => 80,
        'contenu_json' => json_encode([
            'question' => 'Où planifie-t-on une réunion ?',
            'options' => ['Calendrier', 'Fichiers', 'Activité'],
            'reponse' => 'Calendrier'
        ])
      ]
      ]);
    }
}
