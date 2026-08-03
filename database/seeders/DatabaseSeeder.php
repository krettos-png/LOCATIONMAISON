<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- DONNÉES EN PRODUCTION ET EN LOCAL ---
        $this->call([
            utilisateurSeeder::class, // Crée l'administrateur système (et le prof si local)
            categoriesSeeder::class,   // Crée les catégories globales du site
            VilleSeeder::class,        // Crée les villes (dépend des régions)
        ]);

        // --- DONNÉES DE TEST UNIQUEMENT EN LOCAL ---
        if (app()->environment('local', 'testing')) {
            $this->call([
                MaisonSeeder::class,   // Crée les maisons (dépend des utilisateurs et catégories)
                PhotoSeeder::class,    // Ajoute la galerie d'images (dépend des maisons)
                ContratSeeder::class,  // Crée les contrats (dépend des utilisateurs et maisons)
                PaiementSeeder::class, // Crée les paiements (dépend des contrats)
            ]);
        }
    }
}