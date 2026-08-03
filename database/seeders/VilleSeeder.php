<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VilleSeeder extends Seeder
{
    public function run(): void
    {
        $villes = [
            // --- RÉGION MARITIME ---
            ['nom' => 'Lomé', 'region' => 'Maritime'],
            ['nom' => 'Tsévié', 'region' => 'Maritime'],
            ['nom' => 'Aného', 'region' => 'Maritime'],
            ['nom' => 'Tabligbo', 'region' => 'Maritime'],
            ['nom' => 'Vogan', 'region' => 'Maritime'],
            ['nom' => 'Kévé', 'region' => 'Maritime'],
            ['nom' => 'Afagnangan', 'region' => 'Maritime'],
            ['nom' => 'Baguida', 'region' => 'Maritime'],
            ['nom' => 'Agbodrafo', 'region' => 'Maritime'],
            ['nom' => 'Togoville', 'region' => 'Maritime'],
            ['nom' => 'Kpedekpo', 'region' => 'Maritime'],
            ['nom' => 'Noépé', 'region' => 'Maritime'],
            ['nom' => 'Davie', 'region' => 'Maritime'],
            ['nom' => 'Gbatopé', 'region' => 'Maritime'],
            ['nom' => 'Mission Tové', 'region' => 'Maritime'],

            // --- RÉGION DES PLATEAUX ---
            ['nom' => 'Atakpamé', 'region' => 'Plateaux'],
            ['nom' => 'Kpalimé', 'region' => 'Plateaux'],
            ['nom' => 'Badou', 'region' => 'Plateaux'],
            ['nom' => 'Notsé', 'region' => 'Plateaux'],
            ['nom' => 'Amlamé', 'region' => 'Plateaux'],
            ['nom' => 'Elavagnon', 'region' => 'Plateaux'],
            ['nom' => 'Danyi-Apeyeme', 'region' => 'Plateaux'],
            ['nom' => 'Kougnohou', 'region' => 'Plateaux'],
            ['nom' => 'Agou-Gadjagan', 'region' => 'Plateaux'],
            ['nom' => 'Anié', 'region' => 'Plateaux'],
            ['nom' => 'Tohoun', 'region' => 'Plateaux'],
            ['nom' => 'Kévé-Plateaux', 'region' => 'Plateaux'],
            ['nom' => 'Adéta', 'region' => 'Plateaux'],
            ['nom' => 'Kpélé-Akata', 'region' => 'Plateaux'],
            ['nom' => 'Wawa', 'region' => 'Plateaux'],

            // --- RÉGION CENTRALE ---
            ['nom' => 'Sokodé', 'region' => 'Centrale'],
            ['nom' => 'Tchamba', 'region' => 'Centrale'],
            ['nom' => 'Sotouboua', 'region' => 'Centrale'],
            ['nom' => 'Blitta', 'region' => 'Centrale'],
            ['nom' => 'Mô', 'region' => 'Centrale'],
            ['nom' => 'Kadjalla', 'region' => 'Centrale'],
            ['nom' => 'Djebouri', 'region' => 'Centrale'],

            // --- RÉGION DE LA KARA ---
            ['nom' => 'Kara', 'region' => 'Kara'],
            ['nom' => 'Bassar', 'region' => 'Kara'],
            ['nom' => 'Niamtougou', 'region' => 'Kara'],
            ['nom' => 'Bafilo', 'region' => 'Kara'],
            ['nom' => 'Kandé', 'region' => 'Kara'],
            ['nom' => 'Guérin-Kouka', 'region' => 'Kara'],
            ['nom' => 'Pagouda', 'region' => 'Kara'],
            ['nom' => 'Kabou', 'region' => 'Kara'],
            ['nom' => 'Pya', 'region' => 'Kara'],
            ['nom' => 'Kétao', 'region' => 'Kara'],
            ['nom' => 'Bitchabé', 'region' => 'Kara'],

            // --- RÉGION DES SAVANES ---
            ['nom' => 'Dapaong', 'region' => 'Savanes'],
            ['nom' => 'Mango', 'region' => 'Savanes'],
            ['nom' => 'Mandouri', 'region' => 'Savanes'],
            ['nom' => 'Cinkassé', 'region' => 'Savanes'],
            ['nom' => 'Tandjouaré', 'region' => 'Savanes'],
            ['nom' => 'Gando', 'region' => 'Savanes'],
            ['nom' => 'Korbongou', 'region' => 'Savanes'],
            ['nom' => 'Borgou', 'region' => 'Savanes'],
            ['nom' => 'Mogou', 'region' => 'Savanes'],
            ['nom' => 'Boguou', 'region' => 'Savanes'],
            ['nom' => 'Naki-Est', 'region' => 'Savanes'],
        ];

        // Insère les timestamps actuels pour chaque ligne
        $now = now();
        $villesData = array_map(function ($ville) use ($now) {
            return array_merge($ville, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }, $villes);

        // Réinitialise la table pour éviter les doublons lors du seeding
        DB::table('villes')->truncate();
        DB::table('villes')->insert($villesData);
    }
}