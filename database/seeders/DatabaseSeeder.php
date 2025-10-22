<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Maitre;
use App\Models\Tuteur;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::create([

             'nom' => 'Bah',

            'prenom' => 'Amadou',

            'username' => 'doudou',

            'email' => 'user1@example.com',

            'password' => Hash::make('123456'),

        ]);
        //  Maîtres

        $maitre1 = Maitre::create([

            'nom' => 'Tall',

            'prenom' => 'Fatoumata',

            'username' => 'fanta',

            'email' => 'maitre1@example.com',

            'password' => Hash::make('123456'),

            'numero' => '620000000',

            'adresse' => 'Mali',

            'salaire' => 1500000,

        ]);
        //  Tuteurs

        $tuteur1 = Tuteur::create([

            'nom' => 'Bah',

            'prenom' => 'Ibrahima',

            'username' => 'ibra',

            'email' => 'tuteur1@example.com',

            'password' => Hash::make('123456'),

            'numero' => '622222222',

            'profession' => 'Commerçant',

            'adresse' => 'Labé',

        ]);
        $this->command->info('Données de test insérées avec succès !');
    }
}
