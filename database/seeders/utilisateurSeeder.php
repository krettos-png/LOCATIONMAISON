<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class utilisateurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // En local, on nettoie la table pour éviter les doublons
        if (app()->environment('local', 'testing')) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('utilisateurs')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            // text
            DB::table('utilisateurs')->insert([
                'id' => 1,
                'name' => 'client',
                'prenom' => 'Test',
                'contact' => '+228 90 00 00 00',
                'email' => 'client@test.com',
                'password' => Hash::make('Client123'), // Mot de passe sécurisé pour le compte de test
                'role' => 'client',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 2. Compte Administrateur (Pour le local ET la production)
        $adminExiste = DB::table('utilisateurs')->where('email', 'admin@locationmaison.com')->exists();
        
        if (!$adminExiste) {
            DB::table('utilisateurs')->insert([
                'name' => 'Admin',
                'prenom' => 'Principal',
                'contact' => '+228 91 11 11 11',
                'email' => 'admin@locationmaison.com',
                'password' => Hash::make('Admin123'), // À changer après le déploiement
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            DB::table('utilisateurs')->insert([
                'name' => 'Dev',
                'prenom' => 'Principal',
                'contact' => '+228 91 11 11 11',
                'email' => 'dev@locationmaison.com',
                'password' => Hash::make('Dev123!'), // À changer après le déploiement
                'role' => 'dev',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
