<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Defi;

class DefiSeeder extends Seeder
{
    public function run(): void
    {
        $defis = [
            // Excel - Débutant - QCM
            [
                'parcours_id'   => 1,
                'titre'         => 'C\'est quoi une cellule Excel ?',
                'type'          => 'qcm',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => json_encode([
                    'question'    => 'Dans Excel, qu\'est-ce qu\'une cellule ?',
                    'options'     => [
                        'Une ligne du tableau',
                        'Un rectangle qui contient une donnée',
                        'Un graphique',
                        'Un fichier Excel'
                    ],
                    'answer'      => 1,
                    'explication' => 'Une cellule est le petit rectangle où vous tapez vos données. Très bien !'
                ]),
            ],
            // Excel - Débutant - Vrai/Faux
            [
                'parcours_id'   => 1,
                'titre'         => 'Excel fait des calculs automatiques',
                'type'          => 'vrai_faux',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => json_encode([
                    'question'    => 'Excel peut faire des calculs automatiquement.',
                    'answer'      => true,
                    'explication' => 'Exact ! Excel est très puissant pour les calculs. Continuez !'
                ]),
            ],
            // Excel - Intermédiaire - QCM
            [
                'parcours_id'   => 1,
                'titre'         => 'Comment faire une somme ?',
                'type'          => 'qcm',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => json_encode([
                    'question'    => 'Quelle formule additionne des cellules dans Excel ?',
                    'options'     => [
                        '=TOTAL(A1:A10)',
                        '=SOMME(A1:A10)',
                        '=ADDITION(A1:A10)',
                        '=CALCUL(A1:A10)'
                    ],
                    'answer'      => 1,
                    'explication' => 'La formule =SOMME() est la plus utilisée dans Excel. Beau travail !'
                ]),
            ],
            // Excel - Expert - Vrai/Faux
            [
                'parcours_id'   => 1,
                'titre'         => 'Les graphiques Excel',
                'type'          => 'vrai_faux',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => json_encode([
                    'question'    => 'On peut créer des graphiques à partir de données Excel.',
                    'answer'      => true,
                    'explication' => 'Oui ! Excel permet de créer de beaux graphiques. Excellent !'
                ]),
            ],
            // Teams - Débutant - QCM
            [
                'parcours_id'   => 2,
                'titre'         => 'C\'est quoi Microsoft Teams ?',
                'type'          => 'qcm',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => json_encode([
                    'question'    => 'Microsoft Teams est principalement utilisé pour :',
                    'options'     => [
                        'Faire des calculs',
                        'Communiquer et collaborer',
                        'Créer des présentations',
                        'Gérer les finances'
                    ],
                    'answer'      => 1,
                    'explication' => 'Teams est l\'outil de communication d\'équipe. Bravo !'
                ]),
            ],
            // Teams - Débutant - Vrai/Faux
            [
                'parcours_id'   => 2,
                'titre'         => 'Réunions vidéo avec Teams',
                'type'          => 'vrai_faux',
                'niveau'        => 'debutant',
                'xp_recompense' => 10,
                'contenu_json'  => json_encode([
                    'question'    => 'On peut faire des réunions vidéo avec Microsoft Teams.',
                    'answer'      => true,
                    'explication' => 'Tout à fait ! Teams permet les réunions vidéo. Continuez !'
                ]),
            ],
            // Teams - Intermédiaire - QCM
            [
                'parcours_id'   => 2,
                'titre'         => 'Partager un fichier dans Teams',
                'type'          => 'qcm',
                'niveau'        => 'intermediaire',
                'xp_recompense' => 20,
                'contenu_json'  => json_encode([
                    'question'    => 'Comment partager un fichier dans Teams ?',
                    'options'     => [
                        'Par email uniquement',
                        'Via l\'icône trombone dans le chat',
                        'Impossible de partager',
                        'Par clé USB'
                    ],
                    'answer'      => 1,
                    'explication' => 'L\'icône trombone permet de joindre des fichiers. Super !'
                ]),
            ],
            // Teams - Expert - Vrai/Faux
            [
                'parcours_id'   => 2,
                'titre'         => 'Les canaux Teams',
                'type'          => 'vrai_faux',
                'niveau'        => 'expert',
                'xp_recompense' => 30,
                'contenu_json'  => json_encode([
                    'question'    => 'Les canaux Teams organisent les conversations par sujet.',
                    'answer'      => true,
                    'explication' => 'Exactement ! Les canaux organisent le travail. Excellent !'
                ]),
            ],
        ];

        foreach ($defis as $defi) {
            Defi::create($defi);
        }
    }
}