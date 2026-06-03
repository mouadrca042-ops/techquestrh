<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    public function run(): void
    {
        $badges = [
            [
                'titre'            => 'Premier Pas',
                'description'      => 'Vous avez complété votre premier défi !',
                'condition_type'   => 'premier_defi',
                'condition_valeur' => 1,
                'image'            => 'badges/premier_pas.png',
            ],
            [
                'titre'            => 'Assidu',
                'description'      => '5 défis complétés dans la même semaine !',
                'condition_type'   => 'assidu',
                'condition_valeur' => 5,
                'image'            => 'badges/assidu.png',
            ],
            [
                'titre'            => 'Maîtrise',
                'description'      => 'Score parfait sur 3 défis consécutifs !',
                'condition_type'   => 'maitrise',
                'condition_valeur' => 3,
                'image'            => 'badges/maitrise.png',
            ],
            [
                'titre'            => 'Explorateur',
                'description'      => 'Parcours complet terminé. Bravo !',
                'condition_type'   => 'explorateur',
                'condition_valeur' => 1,
                'image'            => 'badges/explorateur.png',
            ],
            [
                'titre'            => '???',
                'description'      => 'Badge secret — continuez à explorer !',
                'condition_type'   => 'secret',
                'condition_valeur' => 10,
                'image'            => 'badges/secret.png',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}