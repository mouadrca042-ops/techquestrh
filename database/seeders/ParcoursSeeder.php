<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Parcours;

class ParcoursSeeder extends Seeder
{
    public function run(): void
    {
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
    }
}