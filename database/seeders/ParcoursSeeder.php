<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parcours;

class ParcoursSeeder extends Seeder
{
    public function run(): void
    {
        // test_positionnement : 3 questions (une par niveau).
        // Score → niveau_depart : 0-1/3 = debutant, 2/3 = intermediaire, 3/3 = expert.

        $parcours = [
            [
                'titre'          => "Les Fondamentaux d'Excel",
                'description'    => 'Maîtrisez les tableaux, les calculs simples et la mise en forme pour gagner du temps au quotidien.',
                'outil'          => 'Excel',
                'nb_defis_total' => 4,
                'test_positionnement' => [
                    'questions' => [
                        [
                            'id'            => 1,
                            'niveau'        => 'debutant',
                            'type'          => 'qcm',
                            'question'      => "Comment sélectionner toute une colonne dans Excel ?",
                            'options'       => [
                                'Ctrl + A',
                                "Cliquer sur la lettre de la colonne (A, B, C…)",
                                'Double-clic sur une cellule',
                                'Ctrl + C',
                            ],
                            'bonne_reponse' => 1,
                        ],
                        [
                            'id'            => 2,
                            'niveau'        => 'intermediaire',
                            'type'          => 'qcm',
                            'question'      => "Quelle formule calcule la moyenne des cellules B1 à B10 ?",
                            'options'       => [
                                '=SOMME(B1:B10)',
                                '=MOYENNE(B1:B10)',
                                '=TOTAL(B1:B10)/10',
                                '=AVG(B1:B10)',
                            ],
                            'bonne_reponse' => 1,
                        ],
                        [
                            'id'            => 3,
                            'niveau'        => 'expert',
                            'type'          => 'qcm',
                            'question'      => "Comment figer la ligne 1 pour qu'elle reste visible lors du défilement ?",
                            'options'       => [
                                'Format > Cellules > Figer',
                                'Affichage > Figer les volets > Figer la ligne supérieure',
                                'Ctrl + F1',
                                'Insertion > Figer',
                            ],
                            'bonne_reponse' => 1,
                        ],
                    ],
                ],
            ],
            [
                'titre'          => 'Maîtriser Microsoft Teams',
                'description'    => 'Apprenez à communiquer, partager des fichiers et organiser des réunions facilement avec vos collègues.',
                'outil'          => 'Teams',
                'nb_defis_total' => 4,
                'test_positionnement' => [
                    'questions' => [
                        [
                            'id'            => 1,
                            'niveau'        => 'debutant',
                            'type'          => 'qcm',
                            'question'      => "Comment envoyer un message privé à un collègue dans Teams ?",
                            'options'       => [
                                "Via le bouton 'Nouvelle conversation'",
                                'Par email depuis Teams',
                                'Via le canal Général',
                                'Impossible dans Teams',
                            ],
                            'bonne_reponse' => 0,
                        ],
                        [
                            'id'            => 2,
                            'niveau'        => 'intermediaire',
                            'type'          => 'qcm',
                            'question'      => "Où retrouver les fichiers partagés dans un canal Teams ?",
                            'options'       => [
                                "Dans l'onglet Fichiers du canal",
                                'Dans les paramètres du compte',
                                'Par email',
                                "Dans l'onglet Applications",
                            ],
                            'bonne_reponse' => 0,
                        ],
                        [
                            'id'            => 3,
                            'niveau'        => 'expert',
                            'type'          => 'qcm',
                            'question'      => "Quelle fonctionnalité permet de travailler simultanément sur un document Word dans Teams ?",
                            'options'       => [
                                "Le partage d'écran",
                                'La co-édition en temps réel',
                                'La visioconférence',
                                "L'envoi par chat",
                            ],
                            'bonne_reponse' => 1,
                        ],
                    ],
                ],
            ],
            [
                'titre'          => "Utiliser l'ERP de l'entreprise",
                'description'    => 'Découvrez comment gérer vos demandes de congés et consulter vos fiches de paie en toute autonomie.',
                'outil'          => 'ERP',
                'nb_defis_total' => 4,
                'test_positionnement' => null,
            ],
            [
                'titre'          => 'Email Professionnel',
                'description'    => 'Gérez vos emails professionnels avec efficacité et professionnalisme.',
                'outil'          => 'Email',
                'nb_defis_total' => 4,
                'test_positionnement' => null,
            ],
        ];

        foreach ($parcours as $p) {
            Parcours::create($p);
        }
    }
}
