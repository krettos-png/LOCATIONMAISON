<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContratSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('contrats')->insert([
            [
                'utilisateur_id' => 1,
                'maison_id'      => 1,
                'date_debut'     => now(),
                'statut'         => 'actif',
                'motif'          => 'RIEN',
                'date_fin'        => null,
                'created_at'     => now(),
                'updated_at'     => now(),
            ],
        ]);
    }
}
