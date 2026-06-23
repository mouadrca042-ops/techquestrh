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
                'image'            => '👣',
            ],
            [
                'titre'            => 'Assidu',
                'description'      => '5 défis complétés dans la même semaine !',
                'condition_type'   => 'assidu',
                'condition_valeur' => 5,
                'image'            => '🔥',
            ],
            [
                'titre'            => 'Maîtrise',
                'description'      => 'Score parfait sur 3 défis consécutifs !',
                'condition_type'   => 'maitrise',
                'condition_valeur' => 3,
                'image'            => '🏆',
            ],
            [
                'titre'            => 'Explorateur',
                'description'      => 'Parcours complet terminé. Bravo !',
                'condition_type'   => 'explorateur',
                'condition_valeur' => 1,
                'image'            => '🧭',
            ],
            [
                'titre'            => '???',
                'description'      => 'Badge secret — réussissez le test final d\'une formation pour le débloquer !',
                'condition_type'   => 'secret',
                'condition_valeur' => 1,
                'image'            => '🎖️',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}