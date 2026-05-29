<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     *
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- DONNÉES EN PRODUCTION ET EN LOCAL ---
        $this->call([
            utilisateurSeeder::class, // Crée l'administrateur système (et le prof si local)
            categoriesSeeder::class,    // Crée les catégories globales du site
        ]);

        // --- DONNÉES DE TEST UNIQUEMENT EN LOCAL ---
        if (app()->environment('local', 'testing')) {
            $this->call([
                MaisonSeeder::class,  // Crée les maisons rattachées à l'utilisateur 1 et aux catégories
                PhotoSeeder::class,   // Ajoute la galerie d'images secondaires
            ]);
        }

    }
}