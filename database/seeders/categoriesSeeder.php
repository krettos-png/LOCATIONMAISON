<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class categoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Désactiver temporairement les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // 2. Utiliser delete() au lieu de truncate()
        DB::table('categories')->delete();
        
        // 3. Réactiver les contraintes
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 4. Insertion de vos catégories
        DB::table('categories')->insert([
            [
                'id' => 1,
                'nom' => 'Habitations',
                'description' => 'https://images.unsplash.com/photo-1613977257363-707ba9348227',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'nom' => 'Bureaux',
                'description' => 'https://images.unsplash.com/photo-1522708323590-d24dbb6b0267',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'nom' => 'Boutiques',
                'description' => 'https://images.unsplash.com/photo-1494526585095-c41746248156',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}