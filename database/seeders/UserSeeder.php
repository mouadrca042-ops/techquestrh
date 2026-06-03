<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'Ahmed Benali',
            'email'    => 'employe@techquest.com',
            'password' => Hash::make('password123'),
            'role'     => 'employe',
            'poste'    => 'Comptable',
            'xp_total' => 0,
            'niveau'   => 'debutant',
        ]);

        User::create([
            'name'     => 'Sara Idrissi',
            'email'    => 'manager@techquest.com',
            'password' => Hash::make('password123'),
            'role'     => 'manager',
            'poste'    => 'Responsable RH',
            'xp_total' => 0,
            'niveau'   => 'debutant',
        ]);

        User::create([
            'name'     => 'Admin TechQuest',
            'email'    => 'admin@techquest.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
            'poste'    => 'Administrateur',
            'xp_total' => 0,
            'niveau'   => 'debutant',
        ]);
    }
}